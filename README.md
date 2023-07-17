php artisan serve para ejecutar la aplicación
npm run watch para cargar los cambios a nivel css

Pagos con stripe:
1-crear cuenta en stripe (https://stripe.com/es)
2-crear producto
3-copiar variables de entorno (STRIPE_KEY | STRIPE_SECRET)
4-Descargar CLI de stripe y donde lo hemos descargado (raíz del proyecto), ejecutamos:
./stripe login --api-key (STRIPE_SECRET)
./stripe listen --forward-to localhost:8000/stripe/webhook (numero de puerto/ruta)

Envios email:

1-crear cuenta en https://mailtrap.io/
2-Con el inbox creado copiar las credenciales en el .env
3-php artisan make:mail -m (nombre del archivo)
4-añadimos en el contructor el from y el contacto a compartir
5-En el controlador llamamos al  Mail::to($user)->send(new ContactShared(auth()->user()->email, $contact->email));