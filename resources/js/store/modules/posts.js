const state = {
    newsPosts: null,
    newsPostsStatus: null
};
const getters = {
    newsPosts: state => {
        return state.newsPosts;
    },
    newsStatus: state => {
        return {
            newsPostsStatus: state.newsPostsStatus
        };
    }
};
const actions = {
    fetchNewsPosts({ commit, state }) {
        commit("setPostsStatus", "loading");
        axios
            .get("/api/posts")
            .then(res => {
                commit("setPostsStatus", "success");
                commit("setPosts", res.data);
            })
            .catch(error => {
                commit("setPostsStatus", "error");
            });
    }
};
const mutations = {
    setPosts(state, posts) {
        state.newsPosts = posts;
    },
    setPostsStatus(state, status) {
        state.newsPostStatus = status;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};
