<?php

namespace App\Http\Controllers;

use App\AboutPage;
use App\Capcha;
use App\Contact;
use App\Design;
use App\DesignOption;
use App\FeedBack;
use App\ImageStorage;
use App\Option;
use App\Order;
use App\Post;
use App\PostComment;
use App\SEO;
use App\Slider;
use App\TypeBathroom;
use App\TypeBuilding;
use App\User;
use App\Work;
use App\WorkDescription;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Validator;
use Exception;

class FrontEndController extends Controller
{
    public function index () {
        date_default_timezone_set('UTC');
        $contact = Contact::where('status', 1)->first();
        $contacts = [];
        $title = false;
        $keywords = false;
        $description = false;
        $SEO = SEO::where([
            ['original_url', '=' ,'/'],
            ['status', '=', '1'],
        ])->first();
        if ($SEO) {
            if ($SEO->title) {
                $title = $SEO->title;
            }

            if ($SEO->keywords) {
                $keywords = $SEO->keywords;
            }

            if ($SEO->description) {
                $description = $SEO->description;
            }
        }
        if ($contact) {
            $contacts = [
                'email' => $contact->email,
                'phone' => $contact->phone,
                'phoneToLink' => preg_replace('~\D+~', '', $contact->phone),
                'facebook_link' => $contact->facebook_link,
                'instagram_link' => $contact->instagram_link,
                'address' => $contact->address,
                'longitude' => $contact->longitude,
                'latitude' => $contact->latitude,
            ];
        }

        $slides = Slider::where('status', 1)->get();
        foreach ($slides as &$slide) {
            $IM = new ImageStorage($slide);
            $slide->src = $IM->getCropped('image', 1365, 807)[0];
        }

        $feedbacks = FeedBack::where('status', 1)->get();
        foreach ($feedbacks as &$feedback) {
            $IM = new ImageStorage($feedback);
            $feedback->avatar = $IM->getCropped('avatar', 102, 102)[0];
        }

        $works = Work::where('status', 1)->get();
        foreach ($works as &$work) {
            $IM = new ImageStorage($work);
            $work->miniSrc = $IM->getCropped('image', 340, 224);
            $work->origSrc = $IM->getOrigImage('image');
        }


        $designs = Design::where([
            ['status', '=', '1'],
            ['show_in_main', '=', 1]
        ])->get();
        $iterrator = 0;
        foreach ($designs as &$item) {
            $IM = new ImageStorage($item);
            $item->price = Design::formatPrice($item->price);
            $item->hallMin = $IM->getCropped('hall', 458, 323);
            $item->hall = $IM->getOrigImage('hall');
            $item->bathMin = $IM->getCropped('bath', 225, 323);
            $item->bath = $IM->getOrigImage('bath');
            if ($iterrator%2 == 0) {
                $item->side = 'left';
            } else {
                $item->side = 'right';
            }
            $iterrator++;
        }

        $typesBuilding = TypeBuilding::where('status', 1)->get();
        $typesBathroom = TypeBathroom::where('status', 1)->get();

        $WorkDescription = WorkDescription::first();



        $dateYear = date('Y');

        return view('index', [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'class' => 'gen',


            'contacts' => $contacts,
            'slides' => $slides,
            'feedbacks' => $feedbacks,
            'workDescription' => $WorkDescription,
            'works' => $works,
            'designs' => $designs,
            'dateYear' => $dateYear,
            'typesBuilding' => $typesBuilding,
            'typesBathroom' => $typesBathroom,
        ]);
    }

    public function sitemap() {
        echo '<?xml version="1.0" encoding="UTF-8"?>'."\n\r";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n\r";
        echo '    <url>'."\n\r";
        echo '        <loc>http://'.$_SERVER['HTTP_HOST'].'</loc>'."\n\r";
        echo '        <lastmod>'.date('Y-m-d').'</lastmod>'."\n\r";
        echo '        <changefreq>weekly</changefreq>'."\n\r";
        echo '        <priority>1</priority>'."\n\r";
        echo '    </url>'."\n\r";
        //Добавим страницу блог
        echo '    <url>'."\n\r";
        echo '        <loc>http://'.$_SERVER['HTTP_HOST'].'/blog/</loc>'."\n\r";
        echo '        <lastmod>'.date('Y-m-d').'</lastmod>'."\n\r";
        echo '        <changefreq>weekly</changefreq>'."\n\r";
        echo '        <priority>1</priority>'."\n\r";
        echo '    </url>'."\n\r";
        //Добавим статьи
        $Posts = Post::all();
        foreach ($Posts as $post) {
            $SEO = SEO::where(['original_url'=>'blog/'.$post->id, 'status'=>1])->first();
            $alias = 'blog/'.$post->id;
            if ($SEO) {
                if ($SEO->alias_url != "") {
                    $alias = $SEO->alias_url;
                }
            };
            echo '    <url>'."\n\r";
            echo '        <loc>http://'.$_SERVER['HTTP_HOST'].'/'.$alias.'</loc>'."\n\r";
            echo '        <lastmod>'.date('Y-m-d').'</lastmod>'."\n\r";
            echo '        <changefreq>weekly</changefreq>'."\n\r";
            echo '        <priority>1</priority>'."\n\r";
            echo '    </url>'."\n\r";
        }
        //Добавим страницу "О компании"
        $AboutPage = AboutPage::first();
        $SEO = SEO::where(['original_url'=>'about', 'status'=>1])->first();
        $alias = 'about';
        if ($SEO) {
            $alias = $SEO->alias_url;
        }
        echo '    <url>'."\n\r";
        echo '        <loc>http://'.$_SERVER['HTTP_HOST'].'/'.$alias.'</loc>'."\n\r";
        echo '        <lastmod>'.date('Y-m-d').'</lastmod>'."\n\r";
        echo '        <changefreq>weekly</changefreq>'."\n\r";
        echo '        <priority>1</priority>'."\n\r";
        echo '    </url>'."\n\r";
        echo '</urlset>';
        die();
    }

    public function constructor_step_2 (Request $request) {
        date_default_timezone_set('UTC');
        $validator = Validator::make($request->all(), [
            'apartments_type' => 'required|max:255',
            'apartments_square' => 'numeric|required',
            'type_building_id' => 'numeric|required',
            'type_bathroom_id' => 'numeric|required',
            'design'           => 'numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator);
        }

        if ($request->design) {
            $design = Design::where([
                'status' => 1,
                'id' => $request->design,
            ])->first();
            if ($design) {
                return redirect('/constructor/step/3/'.$request->design.'/');
            }
        }

        session(['orderCarcas' => []]);
        $orderCarcas = [];
        if (isset($request->address)) {
            $orderCarcas['address'] = $request->address;
        }
        $orderCarcas['apartments_type'] = $request->apartments_type;
        $orderCarcas['apartments_square'] = $request->apartments_square;
        $orderCarcas['type_building_id'] = $request->type_building_id;
        $orderCarcas['type_bathroom_id'] = $request->type_bathroom_id;
        session(['orderCarcas' => $orderCarcas]);

        /* Подготовим вьюху для отображения второго шага регистрации заказа */
        date_default_timezone_set('UTC');
        $contact = Contact::where('status', 1)->first();
        $contacts = [];
        if ($contact) {
            $contacts = [
                'email' => $contact->email,
                'phone' => $contact->phone,
                'phoneToLink' => preg_replace('~\D+~', '', $contact->phone),
                'facebook_link' => $contact->facebook_link,
                'instagram_link' => $contact->instagram_link,
                'address' => $contact->address,
                'longitude' => $contact->longitude,
                'latitude' => $contact->latitude,
            ];
        }

        $designs = Design::where([
            ['status', '=', '1'],
        ])->get();
        $iterrator = 0;
        foreach ($designs as &$item) {
            $IM = new ImageStorage($item);
            $item->price = Design::formatPrice($item->price);
            $item->hallMin = $IM->getCropped('hall', 458, 323);
            $item->hall = $IM->getOrigImage('hall');
            $item->bathMin = $IM->getCropped('bath', 225, 323);
            $item->bath = $IM->getOrigImage('bath');
            if ($iterrator%2 == 0) {
                $item->side = 'left';
            } else {
                $item->side = 'right';
            }
            $iterrator++;
        }

        $dateYear = date('Y');

        return view('frontend.constructor.step_2', [
            'contacts' => $contacts,
            'designs' => $designs,
            'dateYear' => $dateYear,
        ]);
    }

    public function constructor_step_3 ($id) {
        $orderCarcas = session('orderCarcas');
        if (!isset($orderCarcas) || empty($orderCarcas)) {
            return redirect('/');
        }

        $orderCarcas['design_id'] = $id;
        session(['orderCarcas' => $orderCarcas]);

        /* Подготовим вывод опций категорий для выбранного дизайна */
        $scripts[] = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js';
        $scripts[] = '/js/step_3.js';

        date_default_timezone_set('UTC');
        $contact = Contact::where('status', 1)->first();
        $contacts = [];
        if ($contact) {
            $contacts = [
                'email' => $contact->email,
                'phone' => $contact->phone,
                'phoneToLink' => preg_replace('~\D+~', '', $contact->phone),
                'facebook_link' => $contact->facebook_link,
                'instagram_link' => $contact->instagram_link,
                'address' => $contact->address,
                'longitude' => $contact->longitude,
                'latitude' => $contact->latitude,
            ];
        }

        $design = Design::find($id);
        if ($design->status != 1) {
            abort(404);
        }
        $IM = new ImageStorage($design);
        $design->hall = $IM->getCropped('hall', 590, 530);
        $design->bath = $IM->getCropped('bath', 405, 530);

        /* Рассчитаем сумму которую запишем в заказ */
        $typeBuilding = TypeBuilding::find($orderCarcas['type_building_id']);
        if (!$typeBuilding) {
            return redirect('/')->withErrors(['errors'=>['Не выбран тип здания']]);
        }
        $typeBathroom = TypeBathroom::find($orderCarcas['type_bathroom_id']);
        if (!$typeBathroom) {
            return redirect('/')->withErrors(['errors'=>['Не выбран тип санузла']]);
        }

        $summ = Order::getFastCalculate($orderCarcas['apartments_square'], $design->price_square, $design->constant_cy, [], $typeBuilding->additional_coefficient, $typeBathroom->additional_coefficient);
        $dateYear = date('Y');

        $designCategorys = $design->CategoryDesigns;
        $categoryAndOptions = [];
        foreach ($designCategorys as $designCategory) {
            $row = [];
            $row['nameCategory'] = $designCategory->name;
            $row['idCategory'] = $designCategory->id;
            $optionsCategory = $designCategory->DesignOptions;
            $options = [];
            foreach ($optionsCategory as $optionCategory) {
                $option = [];
                $option['id'] = $optionCategory['id'];
                $option['color'] = $optionCategory['color'];
                $option['name'] = $optionCategory['name'];
                $option['price'] = $optionCategory['price'];

                $IM = new ImageStorage($optionCategory);
                $option['hall'] = $IM->getCropped('hall', 590, 530)[0];

                $option['bath'] = false;
                $bathImg = $IM->getCropped('bath', 405, 530);
                if (!empty($bathImg)) {
                    $option['bath'] = $bathImg[0];
                }
                $options[] = $option;
            }
            $row['options'] = $options;
            $categoryAndOptions[] = $row;
        }

        return view('frontend.constructor.step_3', [
            'contacts' => $contacts,
            'design' => $design,
            'dateYear' => $dateYear,
            'summ' => $summ,
            'categoryAndOptions'=> $categoryAndOptions,
            'scripts'=> $scripts,
        ]);
    }


    public function constructor_step_4 (Request $request) {
        $orderCarcas = session('orderCarcas');
        $design = Design::find($orderCarcas['design_id']);
        $designOprions = [];
        $price = 0;
        /* Получить все категории которые связаны с заказом и по их номерам пройтись по request для сохранения опций */
        foreach($design->CategoryDesigns as $category) {
            if(isset($_REQUEST['category'.$category->id])) {
                $designOprions[] = $_REQUEST['category'.$category->id];
                $price = $price + DesignOption::find($_REQUEST['category'.$category->id])->price;
            }
        }

        $orderCarcas['designOptions'] = $designOprions;
        session(['orderCarcas' => $orderCarcas]);

        $typeBuilding = TypeBuilding::find($orderCarcas['type_building_id']);
        if (!$typeBuilding) {
            return redirect('/')->withErrors(['errors'=>['Не выбран тип здания']]);
        }
        $typeBathroom = TypeBathroom::find($orderCarcas['type_bathroom_id']);
        if (!$typeBathroom) {
            return redirect('/')->withErrors(['errors'=>['Не выбран тип санузла']]);
        }

        $summ = Order::getFastCalculate($orderCarcas['apartments_square'], $design->price_square, $design->constant_cy, [], $typeBuilding->additional_coefficient, $typeBathroom->additional_coefficient);
        $summ = $summ + $price;

        $Options = Option::where('status', '1')->get();

        date_default_timezone_set('UTC');
        $contact = Contact::where('status', 1)->first();
        $contacts = [];
        if ($contact) {
            $contacts = [
                'email' => $contact->email,
                'phone' => $contact->phone,
                'phoneToLink' => preg_replace('~\D+~', '', $contact->phone),
                'facebook_link' => $contact->facebook_link,
                'instagram_link' => $contact->instagram_link,
                'address' => $contact->address,
                'longitude' => $contact->longitude,
                'latitude' => $contact->latitude,
            ];
        }
        $dateYear = date('Y');

        $scripts[] = '/js/step_4.js';

        return view('frontend.constructor.step_4', [
            'contacts' => $contacts,
            'dateYear' => $dateYear,
            'summ' => $summ,
            'options' => $Options,
            'scripts'=> $scripts,
            'apartments_square' => $orderCarcas['apartments_square'],
        ]);
    }

    public function constructor_step_5 (Request $request) {
        $users = User::where('send_mail', 1)->get();
        $mailStr = '';
        foreach ($users as $user) {
            if ($mailStr == '') {
                $mailStr .= $user->email;
            } else {
                $mailStr .= ', '.$user->email;
            }
        }

        if ($request->ajax) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'email|required|max:255',
                'theme' => 'max:255',
                'message' => 'required'
            ]);

            if($validator->fails()) {
                $messages = $validator->errors();
                $messagesResponse = [];
                foreach($messages->all() as $message) {
                    $messagesResponse[] = '<li>'.$message.'</li>';
                }
                $messagesResponse = implode('', $messagesResponse);
                $messagesResponse = str_replace('name', 'Имя', $messagesResponse);
                $messagesResponse = str_replace('message', 'Сообщение', $messagesResponse);
                $messagesResponse = str_replace('theme', 'Тема', $messagesResponse);
                die("<p style='font: 13px Verdana;'><font color=#FF3333></font></p><ul class='error-box' style=''>".$messagesResponse."</ul><br />");
            }

            try {
                $Order = new Order();
                $Order->name = $request->name;
                $Order->email = $request->email;
                $Order->message = $request->message;
                $Order->theme = $request->theme;
                $Order->status = 0;
                $Order->save();

                mail ($mailStr, 'Новая заявка с сайта kvadrat.space', 'Новая заявка от '.$Order->name.' Email адресом '.$Order->email.' Темой: '.$Order->theme.'. Доступна по адресу http://kvadrat.space/home/orders/'.$Order->id.'/.');
            } catch (Exception $e) {
                die("<p style='font: 13px Verdana;'><font color=#FF3333></font></p><ul class='error-box' style=''><li>Произошла ошибка при сохранении заявки. Пожалуйста, попробуйте отправить сообщение позже.</li></ul><br />");
            }

            die('1');
        }

        $orderCarcas = session('orderCarcas');
        /* Сохраним все выбранные опции, посе проинициализируем объект заказа и сохраним его */
        $Options = Option::all();
        $optionsArray = [];
        foreach ($Options as $option) {
            if (isset($_REQUEST['option'.$option->id])) {
                $optionsArray[] = $_REQUEST['option'.$option->id];
            }
        }
        $orderCarcas['options'] = $optionsArray;
        $orderCarcas['email'] = $_REQUEST['email'];
        $orderCarcas['phone'] = $_REQUEST['phone'];
        session(['orderCarcas' => []]);
        try {
            $Order = new Order();
            $Order->email = $orderCarcas['email'];
            $Order->address = $orderCarcas['address'];
            $Order->apartments_type = $orderCarcas['apartments_type'];
            $Order->apartments_square = $orderCarcas['apartments_square'];
            $Order->type_building_id = $orderCarcas['type_building_id'];
            $Order->type_bathroom_id = $orderCarcas['type_bathroom_id'];
            $Order->phone  = $orderCarcas['phone'];
            $Order->design_id = $orderCarcas['design_id'];
            $Order->save();

            mail ($mailStr, 'Новый заказ с сайта kvadrat.space', 'Новый заказ от '.$Order->email.' Доступна по адресу http://kvadrat.space/home/orders/'.$Order->id.'/.');

            $Order->DesignOptions()->sync($orderCarcas['designOptions']);
            $Order->Options()->sync($orderCarcas['options']);
        } catch (Exception $e) {
            //пока ничего не делаем
        }


        return redirect('/');
    }

    public function blog_list (Request $request) {
        $SEO = SEO::getCurrentSEO();
        $title = '';
        $keywords = '';
        $description = '';
        if ($SEO) {
            $title = $SEO->title;
            $keywords = $SEO->keywords;
            $description = $SEO->description;
        }

        //Тут необходимая выборка элементов списка
        $currentDate = date('Y-m-d');
        $Posts= Post::where([
            ['status', '=', 1],
            ['date_publication', '<=', $currentDate]])->orderBy('date_publication', 'desc')->paginate(7);

        //Отсчет надо вести со второго элемента и каждому третьему начиная со второго присваивать статус last
        $counter = 0;
        foreach ($Posts as &$post) {
            $IM = new ImageStorage($post);
            if ($counter == 0) {
                $post->cover = $IM->getCropped('cover', 900, 598);
            } else {
                $post->cover = $IM->getCropped('cover', 270, 180);
            }

            if ($counter != 0 && $counter%3==0) {
                $post->class = 'last';
            } else {
                $post->class = '';
            }
        }

        //Обязательные данные
        $contact = Contact::where('status', 1)->first();
        $typesBuilding = TypeBuilding::where('status', 1)->get();
        $typesBathroom = TypeBathroom::where('status', 1)->get();
        $dateYear = date('Y');

        return view('frontend.blog.list', [
            'contacts' => $contact->toArray(),
            'typesBuilding' => $typesBuilding,
            'typesBathroom' => $typesBathroom,
            'blogActive' => true,
            'dateYear' => $dateYear,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'list'=>$Posts,
        ]);
    }

    public function about() {
        $SEO = SEO::getCurrentSEO();
        $title = null;
        $keywords = null;
        $description = null;
        if ($SEO) {
            $title = $SEO->title;
            $keywords = $SEO->keywords;
            $description = $SEO->description;
        }

        //Тут необходимая выборка элементов списка
        $contact = Contact::where('status', 1)->first();
        $typesBuilding = TypeBuilding::where('status', 1)->get();
        $typesBathroom = TypeBathroom::where('status', 1)->get();
        $dateYear = date('Y');

        $AboutPage = AboutPage::all()->first();
        if (!$AboutPage) {
            abort(404, 'Страница не найдена');
        }

        return view('frontend.about.item', [
            'contacts' => $contact->toArray(),
            'typesBuilding' => $typesBuilding,
            'typesBathroom' => $typesBathroom,
            'aboutActive' => true,
            'dateYear' => $dateYear,
            'item' => $AboutPage,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
        ]);
    }

    public function blog_item ($id) {
        $SEO = SEO::getCurrentSEO();
        $title = null;
        $keywords = null;
        $description = null;
        if ($SEO) {
            $title = $SEO->title;
            $keywords = $SEO->keywords;
            $description = $SEO->description;
        }

        //Тут необходимая выборка элементов списка
        $contact = Contact::where('status', 1)->first();
        $typesBuilding = TypeBuilding::where('status', 1)->get();
        $typesBathroom = TypeBathroom::where('status', 1)->get();
        $dateYear = date('Y');

        $post = Post::find($id);
        if (!$post) {
            abort(404, 'Страница не найдена');
        }

        if(!$SEO) {
            $title = $post->name;
            $keywords = $post->lead;
            $description = $post->lead;
        }

        $IM = new ImageStorage($post);
        $post->cover = $IM->getCropped('cover', 900, 598);

        $currentDate = date('Y-m-d');
        $threeLastNews = Post::where([
            ['status', '=', 1],
            ['date_publication', '<=', $currentDate],
            ['id', '<>', $id]])->orderBy('date_publication', 'desc')->limit(3)->get();
        $counter = 0;
        foreach ($threeLastNews as &$lastNew){
            $IM = new ImageStorage($lastNew);
            $lastNew->cover = $IM->getCropped('cover', 270, 180);
            if ($counter == 2) {
                $lastNew->class = 'last';
            }
            $counter++;
        }

        $capchaImage = Capcha::getCapcha(100, 23);

        $Comments = $post->postComments;

        return view('frontend.blog.item', [
            'contacts' => $contact->toArray(),
            'typesBuilding' => $typesBuilding,
            'typesBathroom' => $typesBathroom,
            'blogActive' => true,
            'dateYear' => $dateYear,
            'item' => $post,
            'lastNews' => $threeLastNews,
            'capcha' => $capchaImage,
            'comments' => $Comments,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
        ]);
    }

    public function blog_item_comment(Request $request, $id) {

        $Post = Post::find($id);
        if (!$Post) {
            abort('404');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255|required',
            'email' => 'email|required',
            'message' => 'string| required'
        ]);

        if ($validator->fails()) {
            return redirect('/blog/'.$id.'/#form_comment')->withInput()->with(['errors' => ['Проверьте, что заполнены все поля.']]);
        }

        if (!isset($request->capcha)) {
            return redirect('/blog/'.$id.'/#form_comment')->withInput()->with(['errors' => ['Вы не ввели код.']]);
        }

        if (!Capcha::checkCapcha($request->capcha)) {
            return redirect('/blog/'.$id.'/#form_comment')->withInput()->with(['errors' => ['Код введен не верно.']]);
        }

        $PostComment = new PostComment();
        $PostComment->name = $request->name;
        $PostComment->email = $request->email;
        $PostComment->message = $request->message;
        $PostComment->date_create = date('Y-m-d');
        $PostComment->post_id = $id;
        $PostComment->save();

        return redirect('/blog/'.$id.'/#form_comment');
    }
}
