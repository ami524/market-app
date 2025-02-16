<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Like;
use App\Models\Order;
use App\Models\Sell;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\RegisterRequest;

class ItemController extends Controller
{
    // 会員登録フォームを表示
    public function showRegistrationForm()
    {
        return view('register', ['headerType' => 'default']);
    }


    // 会員登録処理
    public function register(RegisterRequest $request)
    {
        // バリデーションを通過したデータを取得
        $validated = $request->validated();

        // ユーザーの作成
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // ログイン状態にしてリダイレクト
        return redirect()->route('login')->with('success', '登録が完了しました。ログインしてください。');
    }



    // プロフィール設定画面を表示
    public function edit()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
        $user = Auth::user(); // ログイン中のユーザー情報を取得
        return view('mypage-edit', compact('user'));
    }


    // プロフィール情報を更新
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        // プロフィール画像のアップロード処理
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        };

        // 他の情報を更新
        $user->update([
            'name' => $request->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
        ]);

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました');
    }


    public function showLoginForm()
    {
        return view('login', ['headerType' => 'default']);
    }


    public function index()
    {
        $products = Product::all();

        // ログイン状態に応じてヘッダータイプを設定
        $headerType = Auth::check() ? 'logged_in' : 'logged_out';

        // 現在ログイン中のユーザーIDを取得
        $userId = Auth::id();

        // おすすめ商品（自分が出品した商品以外を表示）
        $recommendedProducts = Product::where('user_id', '!=', $userId)->get();

        // いいねした商品（ログインしている場合のみ取得）
        $likedProducts = Auth::check() ? Auth::user()->likedProducts : collect();

        // ビューにデータを渡す
        return view('index', compact('products', 'headerType', 'recommendedProducts', 'likedProducts'));
    }


    /**
     * ログイン処理
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 初回ログインならプロフィール設定画面へリダイレクト
            if ($user->is_first_login) {
                $user->update(['is_first_login' => false]); // フラグを更新
                return redirect()->route('profile.edit');
            }

            // 通常のリダイレクト先
            return redirect()->intended('/mypage');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    /**
     * 商品出品画面の表示
     */
    public function create()
    {
        $categories = ['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'];
        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];

        return view('listing', compact('categories', 'conditions'));
    }

    /**
     * 商品を出品する処理
     */
    public function store(ExhibitionRequest $request)
    {
        $imagePath = $request->file('image')->store('product_images', 'public');

        $product = Product::create([
            'user_id' => Auth::id(),
            'image' => $imagePath,
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
        ]);

        // カテゴリーを保存
        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('mypage')->with('success', '商品を出品しました');
    }

    /**
     * コメントを投稿する処理
     */
    public function addComment(CommentRequest $request, $id)
    {
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'コメントを投稿しました');
    }

    /**
     * ログアウト
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); // 現在のユーザーをログアウト
        $request->session()->invalidate(); // セッションを無効化
        $request->session()->regenerateToken(); // CSRFトークンを再生成

        return redirect('/'); // ログアウト後のリダイレクト先
    }


    public function search(Request $request)
    {
    // 入力された検索キーワードを取得
    $searchTerm = $request->input('search');

    // 商品名で部分一致検索
    $products = Product::where('name', 'like', '%' . $searchTerm . '%')->get();

    // 検索結果をビューに渡す
    return view('search-results', compact('products'));
    }


public function completeOrder($productId)
    {
    // 商品を取得
    $product = Product::find($productId);

    if ($product) {
        // 商品が存在し、まだ販売されていない場合
        if (!$product->is_sold) {
            // 商品を販売済みにする
            $product->is_sold = true;
            $product->save();

            // 注文処理のその他のロジック
            // ...

            return redirect()->route('order.success')->with('success', '購入が完了しました。');
        } else {
            return redirect()->route('order.failure')->with('error', 'この商品は既に販売済みです。');
        }
    }

    return redirect()->route('order.failure')->with('error', '商品が見つかりません。');
    }


public function show($id){
        // 商品を取得
        $product = Product::with(['likes', 'comments'])->withCount(['likes', 'comments'])->find($id);

        // 商品が存在しない場合
        if (!$product) {
            return redirect()->route('index')->with('error', '商品が見つかりません。');
        }

        $liked = auth()->check() && $product->likes->contains('user_id', auth()->id());

        // 商品が購入済みの場合
        if ($product->is_sold) {
            return redirect()->route('index')->with('error', 'この商品は購入済みのため、詳細を見ることができません。');
        }

        // 商品詳細を表示
        return view('detail', compact('product', 'liked'));
    }


    public function toggleLike($productId) {
        $user = Auth::user();
        $product = Product::findOrFail($productId);

        if (!$user) {
            return response()->json(['error' => 'ログインが必要です'], 401);
        }

        // すでに「いいね」しているかチェック
        $like = Like::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($like) {
            // いいねを削除
            $like->delete();
            return response()->json(['liked' => false, 'likesCount' => $product->likes()->count()]);
        } else {
            // いいねを追加
            Like::create(['user_id' => $user->id, 'product_id' => $productId]);
            return response()->json(['liked' => true, 'likesCount' => $product->likes()->count()]);
        }

        return response()->json([
            'likes_count' => $product->likes()->count(),
            'liked' => $liked
        ]);
    }


    public function showPurchase($item_id)
    {
        $product = Product::findOrFail($item_id); // 商品情報を取得（なければ404エラー）
        $user = auth()->user(); // ログインユーザーの情報を取得
        return view('purchase', compact('product', 'user')); // Blade にデータを渡す
    }


    public function processPurchase(PurchaseRequest $request, $item_id)
    {
        $product = Product::findOrFail($item_id);
        // ここで決済処理などを行う（省略）

        // 商品が未購入の場合のみ購入処理
        if (!$product->is_sold) {
            $product->update(['is_sold' => true]);

            return redirect()->route('mypage')->with('success', '購入が完了しました。');
        }

        return redirect()->route('index')->with('error', 'この商品はすでに購入されています。');
    }


    public function changeAddress($item_id)
    {
        return view('address-edit', compact('item_id'));
    }

    public function mypage(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'sell'); // デフォルトを 'sell' に
        $products = $tab === 'sell' ? $user->sellingProducts : $user->purchasedProducts;

        return view('mypage', compact('user', 'tab', 'products'));
    }


public function editAddress($item_id)
    {
    $user = Auth::user();
        return view('address-edit', compact('user', 'item_id'));
    }


public function updateAddress(AddressRequest $request, $item_id)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

    return redirect()->route('mypage')->with('success', '住所を更新しました');
    }
}


