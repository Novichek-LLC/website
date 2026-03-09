import HomePage from './pages/HomePage.vue';
import ServicesPage from './pages/ServicesPage.vue';
import AboutPage from './pages/AboutPage.vue';
import CasesPage from './pages/CasesPage.vue';
import PricingPage from './pages/PricingPage.vue';
import ContactsPage from './pages/ContactsPage.vue';
import BlogPage from './pages/BlogPage.vue';
import PrivacyPage from './pages/PrivacyPage.vue';
import OfferPage from './pages/OfferPage.vue';
import AdminChatPage from './pages/admin/AdminChatPage.vue';
import ServiceDetailPage from './pages/services/ServiceDetailPage.vue';

export default [
  { path: '/', component: HomePage },
  { path: '/services', component: ServicesPage },
  { path: '/about', component: AboutPage },
  { path: '/cases', component: CasesPage },
  { path: '/pricing', component: PricingPage },
  { path: '/contacts', component: ContactsPage },
  { path: '/blog', component: BlogPage },
  { path: '/privacy', component: PrivacyPage },
  { path: '/offer', component: OfferPage },
  { path: '/admin/chat', component: AdminChatPage },
  {
    path: '/services/:slug',
    component: ServiceDetailPage,
    props: true,
  },
];
