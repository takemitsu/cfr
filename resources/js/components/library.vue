<template>
    <section id="about">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <h2>このサイトに使用されている主な言語・環境等ついて</h2>
                <small>(順不同・思いついた順)</small>
                <ul>
                    <li><a href="https://vps.sakura.ad.jp/">さくらのVPS</a></li>
                    <li><a href="https://www.onamae.com/">お名前.com</a></li>
                    <li>
                        <a href="https://www.php.net/">PHP</a> 7.2.19
                        <ul>
                            <li>7.3 では動作しなかったため</li>
                            <li><a href="https://getcomposer.org/">composer</a></li>
                            <li><a href="https://php-fpm.org/">php-fpm</a></li>
                        </ul>
                    </li>

                    <li><a href="https://nginx.org/en/">nginx</a> 1.14.2</li>
                    <li><a href="https://dev.mysql.com/downloads/mysql/">MySQL Community Server</a> 5.7.25</li>
                    <li><a href="https://redis.io/">Redis</a></li>
                    <li><span class="del">メール</span>
                        <ul>
                            <li>非対応。色々めんどい。</li>
                        </ul>
                    </li>
                    <li>
                        <a href="https://nodejs.org/ja/">node.js</a> 10.15.3
                        <ul>
                            <li>開発用</li>
                            <li>いつの間にか LTS が 10.16.0 に変更されてる。。</li>
                        </ul>
                    </li>
                    <li><a href="https://www.npmjs.com/">npm</a> 6.4.1
                        <ul>
                            <li>開発用</li>
                        </ul>
                    </li>
                    <li>
                        <a href="https://laravel.com/">Laravel</a> 5.8.*
                        <ul>
                            <li>使われている技術等はHP参照で</li>
                            <li>Background, API 用</li>
                            <li><a href="https://getbootstrap.com/docs/4.1/getting-started/introduction/">bootstrap</a>
                                4.1.0
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="https://jp.vuejs.org/index.html">Vue.js</a> 2.5.17
                        <ul>
                            <li>Front を SPA で。基本部分は Laravel 依存。入れたのは以下くらい</li>
                            <li><a href="https://router.vuejs.org/ja/">Vue Router</a> 3.0.6</li>
                            <li><a href="https://www.npmjs.com/package/vue-star-rating">vue-star-rating</a> 1.6.1</li>
                            <li><a href="https://www.npmjs.com/package/vue-analytics">vue-analytics</a> 5.17.0</li>
                            <li>Project毎に og 設定できないので Nuxt.s - SSR または blade にすれば良かったかも</li>
                        </ul>
                    </li>
                    <li><a href="https://www.jetbrains.com/phpstorm/">PhpStorm</a></li>
                </ul>

                <p>思い出したら追加しますが、これどうなってんの？とかあれば、ご質問とかに書いてください。</p>
            </div>
        </div>
    </section>
</template>

<style lang="scss">
    .del {
        text-decoration: line-through;
    }
</style>
