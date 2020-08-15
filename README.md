## Laravel + Vuejs CLI + Passport API

<h4>Setup tutorial</h4>
<a href="https://www.youtube.com/watch?v=PJNIE8lYLMQ">youtube</a>
<br/>
<a href="https://github.com/yyx990803/laravel-vue-cli-3/issues/12"> Npm run build issue fix </a>
<br/>
<a href="https://forum.vuejs.org/t/best-way-to-create-a-mpa-with-vue-js/60723/6">MPA tutorial (For reference only)</a>
<h4> Step by Step </h4>
<br/>
<ul>
    <ol><b>Generate Authentication scaffolding</b> insert <code>php artisan ui:auth</code> on your cli</ol>
    <ol><b>Generate front-end folder for VueJs</b> insert <code>vue create frontend</code> on your cli</ol>
    <ol><b>Install Passport on Laravel</b> <a href="https://laravel.com/docs/7.x/passport"> here </a></ol>
    <ol><b>Install UiKit on VueJs</b> <a href=""> here </a></ol>
</ul>
<br/>
<p> For every migrate. Reinstall artisan via <code>php artisan passport:install</code> on cli and go to '.env' copy the Password Grant Client's secret put it on <code>PASSPORT_CLIENT_SECRET</code></p>

<br/>

<p>Components/Package: Uikit, vue-router, axios, vue-load-image</p>
<p>Table tutorial https://youtu.be/eyBNHwfjF90 </p>