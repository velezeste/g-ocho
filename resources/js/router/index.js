import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import About from '../pages/About';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Tasks from '../components/Tasks';
import AddTask from '../components/AddTask';
import EditTask from '../components/EditTask';

import Users from '../components/Users';
import AddUser from '../components/AddUser';
import EditUser from '../components/EditUser';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'about',
        path: '/about',
        component: About
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'tasks',
        path: '/tasks',
        component: Tasks
    },
    {
        name: 'addtask',
        path: '/tasks/add',
        component: AddTask
    },
    {
        name: 'edittask',
        path: '/tasks/edit/:id',
        component: EditTask
    },
    {
        name: 'users',
        path: '/users',
        component: Users
    },
    {
        name: 'adduser',
        path: '/users/add',
        component: AddUser
    },
    {
        name: 'edituser',
        path: '/users/edit/:id',
        component: EditUser
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
