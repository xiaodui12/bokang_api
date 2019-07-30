const mix = require('laravel-mix');

require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public/modules/demo').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/demo.js')
.sass( __dirname + '/Resources/assets/sass/app.scss', 'css/demo.css');

// 配置scss全局函数，变量
mix.options({
    extractVueStyles: true,
    globalVueStyles: path.resolve(__dirname, 'Resources/assets/sass/_variables.scss')
})

// 配置别名
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'Resources/assets/js')
        }
    },
    output:{
        publicPath:'/modules/demo/'
    }
});

if (mix.inProduction()) {
    mix.version();
}
