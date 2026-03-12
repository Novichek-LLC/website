import { createRouter, createWebHistory } from "vue-router"
import Home from "./pages/Home.vue"
import Services from "./pages/Services.vue"
import Service1C from "./pages/services/Service1C.vue"
import ServiceMarking from "./pages/services/ServiceMarking.vue"
import ServiceMusic from "./pages/services/ServiceMusic.vue"
import ServiceSandblast from "./pages/services/ServiceSandblast.vue"
import ServiceVpn from "./pages/services/ServiceVpn.vue"
import ServiceDesign from "./pages/services/ServiceDesign.vue"
import ServiceSites from "./pages/services/ServiceSites.vue"
import ServiceBots from "./pages/services/ServiceBots.vue"
import ServiceAutomation from "./pages/services/ServiceAutomation.vue"
import ServiceSupport from "./pages/services/ServiceSupport.vue"
import Cases from "./pages/Cases.vue"
import CaseShow from "./pages/CaseShow.vue"
import Blog from "./pages/Blog.vue"
import BlogShow from "./pages/BlogShow.vue"
import About from "./pages/About.vue"
import Contacts from "./pages/Contacts.vue"
import Pricing from "./pages/Pricing.vue"
import Privacy from "./pages/Privacy.vue"
import Offer from "./pages/Offer.vue"
import Faq from "./pages/Faq.vue"
import RetailSolution from "./pages/solutions/RetailSolution.vue"
import BusinessSolution from "./pages/solutions/BusinessSolution.vue"
import DigitalSolution from "./pages/solutions/DigitalSolution.vue"
import RemoteSolution from "./pages/solutions/RemoteSolution.vue"
import Dashboard from "./pages/admin/Dashboard.vue"
import Leads from "./pages/admin/Leads.vue"
import GameServers from "./pages/services/GameServers.vue"
import AdminChat from "./pages/admin/Chat.vue"
import BlogManager from "./pages/admin/BlogManager.vue"
import CasesManager from "./pages/admin/CasesManager.vue"

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", component: Home },
    { path: "/services", component: Services },
    { path: "/services/1c", component: Service1C },
    { path: "/services/marking", component: ServiceMarking },
    { path: "/services/music", component: ServiceMusic },
    { path: "/services/sandblast", component: ServiceSandblast },
    { path: "/services/sandblasting", component: ServiceSandblast },
    { path: "/services/vpn", component: ServiceVpn },
    { path: "/services/design", component: ServiceDesign },
    { path: "/services/sites", component: ServiceSites },
    { path: "/services/bots", component: ServiceBots },
    { path: "/services/automation", component: ServiceAutomation },
    { path: "/services/support", component: ServiceSupport },
    { path: "/services/game-servers", component: GameServers },
    { path: "/solutions/retail", component: RetailSolution },
    { path: "/solutions/business", component: BusinessSolution },
    { path: "/solutions/digital", component: DigitalSolution },
    { path: "/solutions/remote", component: RemoteSolution },
    { path: "/cases", component: Cases },
    { path: "/cases/:slug", component: CaseShow },
    { path: "/blog", component: Blog },
    { path: "/blog/:slug", component: BlogShow },
    { path: "/about", component: About },
    { path: "/contacts", component: Contacts },
    { path: "/pricing", component: Pricing },
    { path: "/privacy", component: Privacy },
    { path: "/offer", component: Offer },
    { path: "/faq", component: Faq },
    { path: "/admin/dashboard", component: Dashboard },
    { path: "/admin/leads", component: Leads },
    { path: "/admin/chat", component: AdminChat },
    { path: "/admin/blog", component: BlogManager },
    { path: "/admin/cases", component: CasesManager }
  ],
  scrollBehavior() { return { top: 0 } }
})
