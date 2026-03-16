# Feature map extracted from the archive

## Public website
- SPA layout served by `WebController@layout`
- News, static pages, user profiles
- Shop, donation groups, special offers, cases
- Game cabinet/profile/settings
- Payments and payment webhooks
- Skin rendering and uploads

## Auth & integrations
- Login, register, password reset
- JWT-based API auth
- Email verification
- VK / Discord / Google / Steam / Telegram / Mailru / Yandex integration
- 2FA via Google Authenticator

## Forum
- Categories, discussions, posts, likes
- Reputation, bans, post templates
- Search via Scout
- Realtime forum chat via Socket.IO

## Admin
- `/admin` SPA shell
- `/api/admin/*` endpoints for dashboard, moderation, RCON, permissions, forum manager
- Backpack CRUD kept only where the archived code depends on it directly
