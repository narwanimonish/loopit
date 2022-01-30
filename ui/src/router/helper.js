export const ifAuthenticated = (to, from, next) => {
  console.log('Executed......');
  if (localStorage.getItem('token')) {
    next();
    return;
  }
  next('/login');
  // router.push({
  //   name: 'Login',
  //   params: {
  //     returnTo: to.path,
  //     query: to.query,
  //   },
  // });
};
