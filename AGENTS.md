# AGENTS.md

Congregation Manager: Symfony application to manage congregations (brothers, territories,
assignments) following a DDD-oriented architecture. Personal open-source R&D project, but meant
to be actually used in the future.

## Architecture

The architecture is heavily inspired by **Sylius** (Contract/Component/Bundle split, resource
pattern, Behat context organization). When in doubt about how to structure something, look at how
Sylius does it.

Development happens in this single repository, but each package under `src/CongregationManager/`
has its own `composer.json` and is meant to be **split into independent repositories** (via
`monorepo-builder.php`, Symplify Monorepo Builder). Treat every package as a standalone,
publishable unit: no shortcuts across package boundaries, dependencies always declared in the
package's own `composer.json`.

Packages are organized in 3 layers with strict dependency rules enforced by PHPArkitect
(`phparkitect.php`):

1. **`Contract/`** — Framework-agnostic abstractions with **zero external dependencies**
   (e.g. `Resource`: `AggregateRoot`, `AggregateRootId`).
2. **`Component/`** — Pure PHP domain packages (`Congregation`, `TerritoryManager`, `User`, `Core`),
   each split into:
    - `Domain/` — models, interfaces, repository interfaces, factories, domain services.
      May depend only on `Contract` + `doctrine/collections`. No framework code.
    - `Application/` — commands + handlers. May depend only on `Contract` + own `Domain`.
    - `Infrastructure/` — in-memory implementations for tests. No Symfony/Doctrine ORM here.
3. **`Bundle/`** — Symfony integration: controllers, forms, Doctrine mapping, Twig, DI config.
    - `Core` bundle: Doctrine entities + XML mappings; imports the other bundles' config.
    - `Admin` / `App` bundles: the two UIs (see below).
    - `Resource` bundle: Doctrine DBAL types.

**`Component/Core` is a composition layer only**: it extends/combines the standalone components to
wire bounded contexts together (e.g. `Core\Domain\Area` extends `TerritoryManager\Area` adding the
`Congregation` relation). Rule for new domain logic: create/extend a **standalone Component**
(reusable bounded context); put code in `Core` only to compose components together.

### Persistence pattern

- Domain models are plain PHP classes in `Component/*/Domain`, always paired with an interface.
- `Bundle/Core/Entity/*` classes are (mostly empty) extensions of the Core domain classes.
- Mapping is **Doctrine XML** in `src/CongregationManager/Bundle/Core/config/doctrine/`
  (`bk_doctrine/` dirs are old backups — ignore them).
- Domain interfaces are bound to entities via `resolveTargetEntity` in
  `Bundle/Core/config/packages/doctrine.php`.

### Application layer pattern

- Use case = Command (mutable DTO, also used directly as Symfony Form data class) +
  `final readonly` Handler with `__invoke(Command $command): void`.
- Handlers are **injected and invoked directly in controllers** — deliberately no message bus:
  responses must be synchronous. Do not introduce Messenger.
- Handlers validate command completeness, use domain factories, persist via repository
  interfaces (`add()` + `flush()`).

## The two UIs

- **Admin** (`Bundle/Admin`, `AdminUser`): platform-level management of multiple congregations
  (setup, invitations). Super-admin area.
- **App** (`Bundle/App`, `AppUser`): daily usage by a single congregation's members.

Users are separate types (`AdminUser` / `AppUser`), each with its own reset-password flow.

## Testing

Pragmatic TDD: write tests where they add value; the full `composer test` suite must always pass.

- **Unit tests (PHPUnit)**: live inside each package (`src/CongregationManager/*/*/tests/`),
  mainly covering `Component` domain logic. Use in-memory infrastructure, no mocks of domain.
- **Behat**: features in `features/admin/` and `features/app/`; Sylius-style contexts in
  `src/CongregationManager/Behat/src/Context/` (`Hook`, `Setup`, `Transform`, `Ui`) with Page
  objects (`Page/Admin`, `Page/App`). New UI features should come with a `.feature` file.
- Tag `@wip` excludes a scenario from the default Behat run.

```bash
composer test        # full gate: pds + ecs + phparkitect + phpstan + psalm + rector + phpunit + behat
composer unit        # phpunit only
composer behat       # behat only
composer ecs         # coding standard
composer phpstan     # static analysis (also: psalm, rector, phparkitect)
```

## Development environment

Default setup is **hybrid** (docs/Usage-Hybrid.md): services (PostgreSQL, etc.) in Docker,
PHP runs locally.

```bash
cp compose.override.local-runtime-sample.yaml compose.override.yaml
docker-compose up -d
symfony serve   # https://localhost:8000
```

Full Docker and fully local setups are documented in `docs/`.

## Domain glossary

- **Congregation** — the tenant unit; has **Brothers** (members).
- Territory hierarchy: **Province > Municipality > Area > Territory**.
- **TerritoryAssignment** — a territory assigned to a recipient with assignment/revocation dates.
- **S13** — the S-13 paper form (territory assignment record) generated from assignments
  (`Domain/S13`, `S13Generator`, `S13Renderer`).

## Conventions

- PHP: `declare(strict_types=1)`, `final` classes by default, interfaces for every domain
  model/service, `#[\Override]` attribute on overridden methods.
- Commit messages: English, imperative ("Add X", continuation of "This commit will...").
  Reference the GitHub issue when possible, e.g. `(#12)`. No Redmine here.
- Never commit or push unless explicitly asked.
