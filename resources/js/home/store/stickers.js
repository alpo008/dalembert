export default {
	state : {
    active: [],
    topPriority: [],
    mediumPriority: [],
    lowPriority: [],
    withAttachment: [],
    emergency: []
	},
	mutations : {
    setStickers(state, payload) {
      state.active = payload.all_stickers;
      state.topPriority = _.filter(payload.all_stickers, ['priority', 1]);
      state.mediumPriority = _.filter(payload.all_stickers, ['priority', 2]);
      state.lowPriority = _.filter(payload.all_stickers, ['priority', 3]);
      state.withAttachment = _.filter(payload.all_stickers, (st) => {return !!st.attachments.length});
      state.emergency = payload.active_stickers;
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
    emergencyStickers(state) {
      return state.emergency;
    },
    emergencyStickersWithoutAttachments(state) {
      return _.filter(state.emergency, (st) => {return !st.attachments.length});
    },
    stickersWithAttachment(state) {
      return state.withAttachment;
    },
    stickerById: (state) => (id) => {
      return state.active.find(sticker => parseInt(sticker.id) === parseInt(id));
    },
    stickerImagePath: (state, getters) => (id, description) => {
      let sticker = getters.stickerById(id);
      if(sticker.attachments.length) {
        let attachment = sticker.attachments.find((att) => {
          return !!att.media && att.media.description === description;
        });
        let path = getters.findOrFail(attachment, 'media.path');
        return !!path ? path.replace('public', '/storage') : null;
      }
      return null;
    },
    stickerFirstImagePath: (state, getters) => (id) => {
      let sticker = getters.stickerById(id);
      if(sticker.attachments.length) {
        let path = getters.findOrFail(sticker, 'attachments.0.media.path');
        return !!path ? path.replace('public', '/storage') : null;
      }
      return null;
    },
	}
}