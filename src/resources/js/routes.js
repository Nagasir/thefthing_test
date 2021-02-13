import Home from "./components/home"
import Add from "./components/add"
import Edit from "./components/edit"
import Detail from "./components/detail"

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/add',
            name: 'add',
            component: Add
        },
        {
            path: '/edit/:id',
            name: 'edit',
            component: Edit,
        },
        {
            path: '/detail/:id',
            name: 'detail',
            component: Detail,
        }
    ]
}
