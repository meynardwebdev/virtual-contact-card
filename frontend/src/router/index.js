// import Home from '../components/Home';
// import About from '../components/About';
import UserList from "../components/UserList";
import UserProfile from "../components/UserProfile";

const routes = {
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/',
            name: 'users',
            component: UserList,
            meta: {
                title: 'User Lists'
            }
        },
        {
            path: '/user/:id',
            name: 'userprofile',
            component: UserProfile,
            // props: true,
            props: (route) => {
                const id = route.params.id;
                return { id }
            },
            meta: {
                title: 'User Profile'
            }
        },
        {
            path: '*',
            redirect: '/',
            component: UserList
        }
    ]
}

export default routes;
