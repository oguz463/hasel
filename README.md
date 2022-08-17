## Notes
- `composer install`
- Create your .env file `cp .env.example .env`
- Configure mysql credentials
- Run `php artisan migrate --seed`
- `php artisan storage:link`
- Run `npm install && npm run dev` make sure you have the latest version of nodejs for Vite
- if you can't see uploaded pictures edit ImageLayout.vue line:23
`<img :src="element.dataURL ? element.dataURL : element.path.slice(7)" :alt="element.name">` 
to
`<img :src="element.dataURL ? element.dataURL : '/storage' + element.path.slice(7)" :alt="element.name">`