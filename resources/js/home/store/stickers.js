export default {
	state : {
    active: [],
    topPriority: [],
    mediumPriority: [],
    lowPriority: [],
    withAttachment: []
	},
	mutations : {
    setStickers(state, payload) {
      state.active = payload.active_stickers;
      state.topPriority = _.filter(payload.active_stickers, ['priority', 1]);
      state.mediumPriority = _.filter(payload.active_stickers, ['priority', 2]);
      state.lowPriority = _.filter(payload.active_stickers, ['priority', 3]);
      state.withAttachment = _.filter(payload.active_stickers, (st) => {return !!st.attachments.length});
    }
	},
	actions : {
	},
	getters: {
    activeStickers(state) {
      return state.active;
    },
    sortedStickers(state) {
      return {
        'top' : state.topPriority,
        'medium' : state.mediumPriority,
        'low' : state.lowPriority
      }
    },
    stickersWithAttachment(state) {
      return state.withAttachment;
    },
    stickerById: (state) => (id) => {
      return state.active.find(sticker => parseInt(sticker.id) === parseInt(id));
    },
    stickerImagePath: (state, getters) => (id) => {
      let sticker = getters.stickerById(id);
      let path = getters.findOrFail(sticker, 'attachments.0.media.path');
      return !!path ? path.replace('public', '/storage') : null;
    },
	}
}