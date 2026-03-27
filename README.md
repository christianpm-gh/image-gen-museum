# image-gen-museum

Aplicacion Laravel para un museo conceptual donde los usuarios compran tickets mock y generan recuerdos visuales con OpenAI a partir de imagenes curadas del catalogo.

## Que construye este proyecto

- Un museo web con autenticacion, sesiones y panel autenticado.
- Un flujo de compra mock que emite tickets `standard` o `premium`.
- Un correo transaccional enviado por Mailtrap cuando la orden se completa.
- Un flujo de generacion asincrona de recuerdos visuales usando OpenAI.
- Persistencia en Supabase Postgres y almacenamiento de assets en Supabase Storage.

## Stack principal

- Laravel 12
- Livewire / Volt
- Tailwind CSS
- Supabase Postgres
- Supabase Storage via compatibilidad S3
- Mailtrap
- OpenAI Images API

## Clonar el repositorio

```bash
git clone https://github.com/christianpm-gh/image-gen-museum.git
cd image-gen-museum
```

## Arranque local rapido

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan queue:work
php artisan serve
```

## Variables que debes configurar

Antes de probar integraciones reales completa en `.env` al menos estos bloques:

```env
APP_URL=

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_SCHEMA=public
DB_SSLMODE=require

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

OPENAI_API_KEY=

SUPABASE_STORAGE_DRIVER=s3
SUPABASE_STORAGE_ENDPOINT=
SUPABASE_STORAGE_REGION=
SUPABASE_STORAGE_KEY=
SUPABASE_STORAGE_SECRET=
SUPABASE_CATALOG_BUCKET=museum-catalog
SUPABASE_GENERATED_BUCKET=generated-memories
```

## Buckets requeridos en Supabase

Crea estos buckets antes de correr el bootstrap de assets:

- `museum-catalog`: publico
- `generated-memories`: privado

Despues sube los assets curados con:

```bash
php artisan museum:bootstrap-assets
```

## Usuario demo

El seeder crea un usuario para probar el flujo completo:

- Email: `demo@example.com`
- Password: `password`

## Como abordar el proyecto desde cero

Si quieres entender el sistema sin perderte, esta es la ruta recomendada:

1. Lee [routes/web.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/routes/web.php) para ver el mapa funcional completo.
2. Revisa [database/seeders/DatabaseSeeder.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/database/seeders/DatabaseSeeder.php) para entender el contenido inicial del museo.
3. Mira los modelos en [app/Models](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Models) para identificar las entidades principales.
4. Sigue el flujo de compra desde [app/Http/Controllers/OrderController.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Http/Controllers/OrderController.php) hacia [app/Services/PurchaseTicketService.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/PurchaseTicketService.php).
5. Revisa la automatizacion del ticket en [app/Observers/OrderObserver.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Observers/OrderObserver.php) y el correo en [app/Mail/TicketIssuedMail.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Mail/TicketIssuedMail.php).
6. Sigue el flujo de recuerdos desde [app/Http/Controllers/MemoryGenerationController.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Http/Controllers/MemoryGenerationController.php) hacia [app/Jobs/ProcessMemoryGenerationJob.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Jobs/ProcessMemoryGenerationJob.php).
7. Por ultimo, entra a los servicios externos en [app/Services/MuseumAssetStorage.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/MuseumAssetStorage.php), [app/Services/OpenAiImageGenerator.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/OpenAiImageGenerator.php) y [app/Services/TicketAccessValidator.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/TicketAccessValidator.php).

## Mapa del dominio

Estas son las piezas mas importantes del negocio:

- `MuseumRoom`: agrupa exposiciones y define el contexto visual de cada sala.
- `Exhibition`: representa una exposicion conceptual dentro de una sala.
- `CatalogImage`: imagen base curada que el usuario puede elegir para su recuerdo.
- `Order`: compra mock del ticket.
- `Ticket`: comprobante emitido al usuario despues de completar la orden.
- `TicketAccessToken`: token opaco enviado por correo y usado para proteger el acceso al generador.
- `MemoryGeneration`: solicitud y resultado del recuerdo visual generado por IA.

## Flujos principales

### 1. Exploracion del museo

- Landing publica en `/`
- Museo autenticado en `/museo`
- Salas en `/salas/{slug}`
- Exposiciones en `/exposiciones/{slug}`

### 2. Compra del ticket

1. El usuario entra a `/tickets/comprar`.
2. Selecciona `standard` o `premium`.
3. `PurchaseTicketService` crea la orden en `pending` y la marca `completed`.
4. El observer emite el ticket y envia el correo.

### 3. Generacion del recuerdo

1. El usuario abre el enlace firmado del ticket.
2. El backend valida ticket, propietario, token y estado.
3. El usuario selecciona 1 imagen si el ticket es `standard` o 2 si es `premium`.
4. La app crea un `memory_generation` en cola.
5. `ProcessMemoryGenerationJob` construye el prompt, llama a OpenAI y guarda el resultado en Supabase Storage.

## Donde vive cada responsabilidad

### HTTP y navegacion

- [app/Http/Controllers/MuseumController.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Http/Controllers/MuseumController.php)
- [app/Http/Controllers/OrderController.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Http/Controllers/OrderController.php)
- [app/Http/Controllers/TicketController.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Http/Controllers/TicketController.php)
- [app/Http/Controllers/MemoryGenerationController.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Http/Controllers/MemoryGenerationController.php)

### Reglas de negocio

- [app/Services/PurchaseTicketService.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/PurchaseTicketService.php)
- [app/Services/TicketIssuanceService.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/TicketIssuanceService.php)
- [app/Services/TicketAccessValidator.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/TicketAccessValidator.php)
- [app/Services/MemoryPromptBuilder.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/MemoryPromptBuilder.php)

### Integraciones externas

- [app/Services/OpenAiImageGenerator.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/OpenAiImageGenerator.php)
- [app/Services/MuseumAssetStorage.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Services/MuseumAssetStorage.php)
- [app/Mail/TicketIssuedMail.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Mail/TicketIssuedMail.php)

### Automatizaciones y asincronia

- [app/Observers/OrderObserver.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Observers/OrderObserver.php)
- [app/Jobs/ProcessMemoryGenerationJob.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/app/Jobs/ProcessMemoryGenerationJob.php)
- [config/queue.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/config/queue.php)

### UI y experiencia

- [resources/views/welcome.blade.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/resources/views/welcome.blade.php)
- [resources/views/museum](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/resources/views/museum)
- [resources/views/orders/create.blade.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/resources/views/orders/create.blade.php)
- [resources/views/memories/create.blade.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/resources/views/memories/create.blade.php)
- [resources/css/app.css](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/resources/css/app.css)

## Como leer el codigo pensando en arquitectura

Una forma util de leer este repo es separar cada recorrido en capas:

1. Entra por una ruta.
2. Mira el controller que prepara datos y delega.
3. Baja al service que contiene la regla de negocio.
4. Revisa si hay observer, mail o job disparado por ese cambio.
5. Termina en modelos, storage o proveedor externo.

En este proyecto la mayor parte de la complejidad vive en integraciones y estados:

- estados de `orders`: `pending`, `completed`, `cancelled`
- estados de `tickets`: `issued`, `reserved`, `consumed`
- estados de `memory_generations`: `queued`, `processing`, `completed`, `failed`

## Pruebas utiles para orientarte

Corre la suite base con:

```bash
php artisan test
```

Si quieres entender el comportamiento del sistema, estas pruebas son las mejores primeras lecturas:

- [tests/Feature/TicketPurchaseTest.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/tests/Feature/TicketPurchaseTest.php)
- [tests/Feature/MemoryAccessTest.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/tests/Feature/MemoryAccessTest.php)
- [tests/Feature/ProcessMemoryGenerationJobTest.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/tests/Feature/ProcessMemoryGenerationJobTest.php)
- [tests/Feature/MuseumAccessTest.php](/C:/Users/xxcmp/OneDrive/Escritorio/POS/image-gen-museum/tests/Feature/MuseumAccessTest.php)

## Revisar el proyecto cronologicamente

Para recorrer la evolucion del proyecto desde el primer commit:

```bash
git log --reverse --date=iso --pretty=format:'%C(yellow)%h%Creset %Cgreen%ad%Creset %s %C(cyan)<%an>%Creset'
```

Para inspeccionar un commit especifico:

```bash
git show <hash>
```

Para comparar dos puntos del historial:

```bash
git diff <hash_inicial>..<hash_final>
```

## Politica de ramas y PRs

- `main` es la rama protegida de referencia.
- El repositorio usa Conventional Commits.
- Todo cambio nuevo deberia entrar con una descripcion clara del impacto funcional.
- Existe una plantilla de PR en `.github/pull_request_template.md`.

## Conventional Commits

Formato:

```text
tipo(scope opcional): descripcion corta en imperativo
```

Tipos recomendados:

- `feat`
- `fix`
- `docs`
- `refactor`
- `test`
- `chore`

Ejemplos:

```text
feat(memory): add async generation workflow
fix(openai): build multipart payload explicitly
docs(readme): add onboarding guide for new contributors
```

## Seguridad

- No subas secretos reales ni API keys.
- Usa `.env.example` para documentar variables sin exponer credenciales.
- Si una credencial se compartio por error, rotala en el proveedor correspondiente.
