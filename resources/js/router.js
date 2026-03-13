import { createRouter, createWebHistory } from "vue-router"
import axios from "axios"

import Home from "./pages/Home.vue"
import Services from "./pages/Services.vue"
import Service1C from "./pages/services/OneCService.vue"
import ServiceMarking from "./pages/services/MarkingService.vue"
import ServiceMusic from "./pages/services/MusicDistributionService.vue"
import ServiceSandblast from "./pages/services/SandblastService.vue"
import ServiceVpn from "./pages/services/VpnInfrastructureService.vue"
import ServiceDesign from "./pages/services/DesignService.vue"
import ServiceSites from "./pages/services/SitesService.vue"
import ServiceBots from "./pages/services/BotsAutomationService.vue"
import ServiceAutomation from "./pages/services/ServiceAutomation.vue"
import SolutionsRetail from "./pages/solutions/RetailSolution.vue"
import SolutionsBussines from "./pages/solutions/BusinessSolution.vue"
import SolutionsDigital from "./pages/solutions/DigitalTeamsSolution.vue"
import SolutionsRemote from "./pages/solutions/RemoteTeamsSolution.vue"
import Solutions from "./pages/Solutions.vue"
import LicenseCenter from "./pages/LicensingCenter.vue"
import Cases from "./pages/Cases.vue"
import CaseShow from "./pages/CaseShow.vue"
import Blog from "./pages/Blog.vue"
import BlogShow from "./pages/BlogShow.vue"
import About from "./pages/About.vue"
import Contacts from "./pages/Contacts.vue"
import Pricing from "./pages/Pricing.vue"
import Privacy from "./pages/Privacy.vue"
import Offer from "./pages/Offer.vue"
import GameServers from "./pages/services/GameServers.vue"
import Documents from "./pages/Documents.vue"
import ConsentPersonalData from "./pages/ConsentPersonalData.vue"
import CookiePolicy from "./pages/CookiePolicy.vue"
import Requisites from "./pages/Requisites.vue"
import Faq from "./pages/Faq.vue"

axios.defaults.withCredentials = true
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"
axios.defaults.headers.common["Accept"] = "application/json"

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", component: Home },

    { path: "/services", component: Services },
    { path: "/services/1c", component: Service1C },
    { path: "/services/marking", component: ServiceMarking },
    { path: "/services/music", component: ServiceMusic },
    { path: "/services/sandblast", component: ServiceSandblast },
    { path: "/services/vpn", component: ServiceVpn },
    { path: "/services/design", component: ServiceDesign },
    { path: "/services/sites", component: ServiceSites },
    { path: "/services/bots", component: ServiceBots },
    { path: "/services/automation", component: ServiceAutomation },
    { path: "/services/game-servers", component: GameServers },

    { path: "/cases", component: Cases },
    { path: "/cases/:slug", component: CaseShow },

    { path: "/blog", component: Blog },
    { path: "/blog/:slug", component: BlogShow },

    { path: "/about", component: About },
    { path: "/contacts", component: Contacts },
    { path: "/pricing", component: Pricing },

    { path: "/privacy", component: Privacy },
    { path: "/offer", component: Offer },
    { path: "/documents", component: Documents },
    { path: "/consent-personal-data", component: ConsentPersonalData },
    { path: "/cookie-policy", component: CookiePolicy },
    { path: "/requisites", component: Requisites },
    { path: "/solutions", component: Solutions },
    { path: "/solutions/retail", component: SolutionsRetail },
    { path: "/solutions/business", component: SolutionsBussines },
    { path: "/solutions/digital-teams", component: SolutionsDigital },
    { path: "/solutions/remote-teams", component: SolutionsRemote },
    { path: "/license-center", component: LicenseCenter },
    { path: "/faq", component: Faq },
    {
      path: "/knowledge",
      component: () => import("./pages/KnowledgeBase.vue"),
    },
    {
      path: "/knowledge/:slug",
      component: () => import("./pages/KnowledgeArticle.vue"),
    },
    {
      path: "/kФnowledge/category/:slug",
      component: () => import("./pages/KnowledgeCategory.vue"),
    },
    {
      path: "/account/login",
      component: () => import("./pages/account/Login.vue"),
      meta: { guestOnly: true },
    },
    {
      path: "/account",
      component: () => import("./layouts/AccountLayout.vue"),
      meta: { requiresAuth: true },
      children: [
        {
          path: "",
          component: () => import("./pages/account/Dashboard.vue"),
        },
        {
          path: "projects",
          component: () => import("./pages/account/Projects.vue"),
        },
        {
          path: "projects/:slug",
          component: () => import("./pages/account/ProjectShow.vue"),
        },
        {
          path: "invoices",
          component: () => import("./pages/account/Invoices.vue"),
        },
        {
          path: "profile",
          component: () => import("./pages/account/Profile.vue"),
        },
        {
          path: "tickets",
          component: () => import("./pages/account/Tickets.vue"),
        },
      ],
    },
  ],
  scrollBehavior() {
    return { top: 0 }
  },
})

let authUser = null
let authChecked = false

async function getAuthUser() {
  if (authChecked) return authUser

  try {
    const { data } = await axios.get("/api/user")
    authUser = data
  } catch {
    authUser = null
  } finally {
    authChecked = true
  }

  return authUser
}

router.beforeEach(async (to) => {
  const user = await getAuthUser()

  if (to.meta.requiresAuth && !user) {
    return {
      path: "/account/login",
      query: { redirect: to.fullPath },
    }
  }

  if (to.meta.guestOnly && user) {
    return "/account"
  }

  return true
})

export default router