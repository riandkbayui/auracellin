export default async function ({ store, redirect, $axios }) {
  try {
    const fetchProfile = async () => {
      const response = await $axios.get('member/profile');
      const user = response.data.user;
      const configs = response.data.configs;
      const packages = response.data.packages;
      store.commit('login', { user });
      store.commit('configs', { configs });
      if(store.getters.getPackages.length==0) {
        store.commit('packages', { packages });
      }
    };

    if (store.getters.isAuthenticated==true) {
      fetchProfile().catch((error) => {
        console.log(error);
        if ([401, 302].includes(error?.response?.status)) {
          redirect('/auth/login');
        }
      });
    } else {
      await fetchProfile();
    }
  } catch (err) {
    console.log(err);
    redirect('/auth/login');
  }
}
