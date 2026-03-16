# Remaining porting work

This baseline is intentionally aimed at getting the project onto a maintainable dependency floor with minimal destructive changes.

## Backend follow-ups
- Verify all Backpack CRUD controllers against Backpack 6 field / column API.
- Re-test payment webhooks and update providers where external APIs changed.
- Re-test JWT guard customization against tymon/jwt-auth 2.x.
- Review forum search indexing commands after moving to Sqlout.
- Review GeoIP and Elfinder integrations in production.

## Frontend follow-ups
- Rebuild both SPAs and fix any remaining Vue 2 runtime warnings component-by-component.
- Replace Socket.IO v2 compatibility layer with Laravel Reverb or a modern Socket.IO stack when the frontend is ready.
- Replace the archived admin theme gradually with a supported design system.

## Recommended next phase
- Public SPA: migrate page-by-page from Vue 2.7 to Vue 3.
- Admin SPA: split legacy Vuetify 1 screens into modules and migrate to Vue 3 + Vuetify 3 or a lighter component library.
