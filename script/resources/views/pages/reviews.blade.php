@extends('layout')

@section('content')




            <section class="inner">
                <div class="bg_faqf"></div>
                <div class="dsasss_rewiews">
                    <p class="faq" style="line-height: 1.2em; color: rgb(232, 214, 129); text-transform: uppercase; font-size: 17px; font-family: inherit; font-weight: bold;">ЭТО РАЗДЕЛ ДЛЯ ОТЗЫВОВ О САЙТЕ, ВАШЕМ ДРОПЕ И ОКУПАЕМОСТИ. Любые другие посты будут удаляться!</p>
                    <p class="faq" style="font-size: 1.2em; line-height: 1.2em;">Убедитесь, что вы прочитали <a href="/faq" onClick="Page.Go(this.href); return false;">FAQ (ответы на вопросы)</a> и не нашли там ответа на свой вопрос.</p>
                </div>
                <br>



                <!-- Put this div tag to the place, where the Comments block will be -->
                <div style="margin: auto; width: 1000px; background: transparent none repeat scroll 0% 0%;" id="vk_comments"></div>
                <script type="text/javascript">
                    VK.Widgets.Comments("vk_comments", {limit: 10, width: "1000", attach: "*"});
                </script>

            </section>




@endsection