//import store from '@/store';

export default function auth({next}) {
    //console.log('hit middleware here');
    //store.commit('account_sign_out');
    //store.commit('login');
    return next();
}