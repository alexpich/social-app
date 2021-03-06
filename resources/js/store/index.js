import Vue from "vue";
import Vuex from "vuex";
import Profile from "./modules/profile";
import User from "./modules/user";
import Title from "./modules/title";
import Posts from "./modules/posts";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Profile,
        User,
        Title,
        Posts
    }
});
