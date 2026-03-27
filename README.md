# image-gen-museum

Aplicacion Laravel para generacion de recuerdos visuales para museo.

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
php artisan serve
```

## Revisar el proyecto cronologicamente

Para recorrer la evolucion del proyecto desde el primer commit:

```bash
git log --reverse --date=iso --pretty=format:'%C(yellow)%h%Creset %Cgreen%ad%Creset %s %C(cyan)<%an>%Creset'
```

Para inspeccionar un commit especifico en detalle:

```bash
git show <hash>
```

Para comparar cambios entre dos puntos de tiempo:

```bash
git diff <hash_inicial>..<hash_final>
```

Para seguir cambios de una linea/archivo en el tiempo:

```bash
git blame <ruta/archivo>
```

## Politica de ramas y PRs

- `main` requiere Pull Request para colaboradores.
- El owner mantiene capacidad de push directo para tareas operativas.
- Todo cambio regular debe entrar via PR con descripcion completa.

## Conventional Commits

Este repositorio usa Conventional Commits. Formato:

```text
tipo(scope opcional): descripcion corta en imperativo
```

Tipos recomendados:

- `feat`: nueva funcionalidad
- `fix`: correccion de bug
- `docs`: cambios de documentacion
- `refactor`: cambios internos sin alterar comportamiento externo
- `test`: pruebas
- `chore`: tareas de mantenimiento

Ejemplos:

```text
feat(memory): add async generation workflow
fix(tickets): prevent duplicate token usage
docs(readme): document repository timeline commands
```

## Seguridad

- No subir secretos ni credenciales.
- `.env` ya esta ignorado por Git.
- Usar valores de ejemplo en `.env.example`.
