export default [
    // ROTA DASHBOARD
        { path: '/dashboard', component: require('./components/Dashboard/Dashboard').default },

    // ROTA DO CADASTRO DE MANAGERS
        { path: '/dashboard/gestor', component: require('./components/Managers/Managers').default },
];
