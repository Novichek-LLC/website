const THEMES = {
  automation: {
    badge: "Автоматизация",
    badgeClass: "border-violet-400/15 bg-violet-400/10 text-violet-200",
    gradientFrom: "#4f46e5",
    gradientTo: "#22c55e",
    glow: "#a78bfa",
  },
  accounting: {
    badge: "1С / Учёт",
    badgeClass: "border-amber-400/15 bg-amber-400/10 text-amber-200",
    gradientFrom: "#f59e0b",
    gradientTo: "#ef4444",
    glow: "#fcd34d",
  },
  marking: {
    badge: "Маркировка",
    badgeClass: "border-emerald-400/15 bg-emerald-400/10 text-emerald-200",
    gradientFrom: "#10b981",
    gradientTo: "#06b6d4",
    glow: "#6ee7b7",
  },
  web: {
    badge: "Digital",
    badgeClass: "border-cyan-400/15 bg-cyan-400/10 text-cyan-200",
    gradientFrom: "#06b6d4",
    gradientTo: "#3b82f6",
    glow: "#67e8f9",
  },
  infrastructure: {
    badge: "Инфраструктура",
    badgeClass: "border-sky-400/15 bg-sky-400/10 text-sky-200",
    gradientFrom: "#0ea5e9",
    gradientTo: "#6366f1",
    glow: "#7dd3fc",
  },
  games: {
    badge: "Игровые серверы",
    badgeClass: "border-fuchsia-400/15 bg-fuchsia-400/10 text-fuchsia-200",
    gradientFrom: "#7c3aed",
    gradientTo: "#ec4899",
    glow: "#d8b4fe",
  },
  music: {
    badge: "Музыка",
    badgeClass: "border-pink-400/15 bg-pink-400/10 text-pink-200",
    gradientFrom: "#ec4899",
    gradientTo: "#8b5cf6",
    glow: "#f9a8d4",
  },
  design: {
    badge: "Дизайн",
    badgeClass: "border-rose-400/15 bg-rose-400/10 text-rose-200",
    gradientFrom: "#fb7185",
    gradientTo: "#8b5cf6",
    glow: "#fda4af",
  },
}

function stripHtml(html = "") {
  return String(html)
    .replace(/<style[\s\S]*?<\/style>/gi, " ")
    .replace(/<script[\s\S]*?<\/script>/gi, " ")
    .replace(/<[^>]+>/g, " ")
    .replace(/\s+/g, " ")
    .trim()
}

function textForAnalysis(post) {
  return [
    post?.title || "",
    post?.excerpt || "",
    stripHtml(post?.content || ""),
    post?.seo_keywords || "",
    post?.seo_description || "",
  ].join(" ").toLowerCase()
}

export function detectBlogTheme(post) {
  const text = textForAnalysis(post)

  if (/(minecraft|rust|игров|сервер|донат|вайп|modpack|spigot|fabric|forge)/i.test(text)) return "games"
  if (/(1с|учет|учёт|erp|бухг|финанс|склад|документооборот)/i.test(text)) return "accounting"
  if (/(маркиров|честный знак|контур|товар|qr|datamatrix)/i.test(text)) return "marking"
  if (/(vpn|инфраструкт|сервер|безопасн|доступ|сеть|remote|devops)/i.test(text)) return "infrastructure"
  if (/(сайт|landing|seo|конверси|лендинг|digital|лид|маркетинг|трафик)/i.test(text)) return "web"
  if (/(дизайн|ui|ux|бренд|айдентик|интерфейс|визуал)/i.test(text)) return "design"
  if (/(музык|лейбл|релиз|дистриб|spotify|apple music|артист)/i.test(text)) return "music"

  return "automation"
}

export function resolveBlogTheme(post) {
  const key = post?.visual_theme && THEMES[post.visual_theme]
    ? post.visual_theme
    : detectBlogTheme(post)

  return {
    key,
    ...THEMES[key],
  }
}

export function resolveBlogBadge(post) {
  const theme = resolveBlogTheme(post)

  return {
    label: post?.badge_label || theme.badge,
    className: theme.badgeClass,
  }
}

export function estimateReadingTime(content = "") {
  const text = stripHtml(content)
  const words = text ? text.split(/\s+/).length : 0
  const minutes = Math.max(1, Math.ceil(words / 180))
  return `${minutes} мин чтения`
}

export function buildBlogCover(post) {
  if (post?.cover_url) return post.cover_url

  const theme = resolveBlogTheme(post)
  const title = (post?.title || "Публикация").slice(0, 72)
  const excerpt = (post?.excerpt || stripHtml(post?.content || "") || "Материал компании NOVICHEK").slice(0, 120)
  const badge = resolveBlogBadge(post).label

  const svg = `
  <svg width="1200" height="720" viewBox="0 0 1200 720" fill="none" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="g" x1="0" y1="0" x2="1200" y2="720" gradientUnits="userSpaceOnUse">
        <stop stop-color="${theme.gradientFrom}"/>
        <stop offset="1" stop-color="${theme.gradientTo}"/>
      </linearGradient>
      <radialGradient id="glow" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(960 140) rotate(90) scale(220 280)">
        <stop stop-color="${theme.glow}" stop-opacity="0.55"/>
        <stop offset="1" stop-color="${theme.glow}" stop-opacity="0"/>
      </radialGradient>
    </defs>

    <rect width="1200" height="720" rx="40" fill="#0B1220"/>
    <rect width="1200" height="720" rx="40" fill="url(#g)" fill-opacity="0.18"/>
    <rect width="1200" height="720" rx="40" fill="url(#glow)"/>

    <g opacity="0.16">
      <circle cx="1020" cy="120" r="150" fill="${theme.glow}"/>
      <circle cx="1080" cy="600" r="120" fill="${theme.gradientTo}"/>
      <circle cx="160" cy="560" r="110" fill="${theme.gradientFrom}"/>
    </g>

    <rect x="56" y="56" width="220" height="46" rx="23" fill="rgba(255,255,255,0.08)"/>
    <text x="82" y="85" fill="white" font-size="22" font-family="Inter, Arial, sans-serif" font-weight="600">${escapeXml(badge)}</text>

    <text x="56" y="210" fill="white" font-size="64" font-family="Inter, Arial, sans-serif" font-weight="700">${escapeXml(title)}</text>
    <text x="56" y="300" fill="#CBD5E1" font-size="28" font-family="Inter, Arial, sans-serif" font-weight="400">${escapeXml(excerpt)}</text>

    <rect x="56" y="602" width="220" height="50" rx="18" fill="rgba(255,255,255,0.08)"/>
    <text x="88" y="634" fill="white" font-size="24" font-family="Inter, Arial, sans-serif" font-weight="600">NOVICHEK</text>
  </svg>`

  return `data:image/svg+xml;charset=UTF-8,${encodeURIComponent(svg)}`
}

function escapeXml(value = "") {
  return String(value)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&apos;")
}