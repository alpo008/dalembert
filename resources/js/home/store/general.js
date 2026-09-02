export default {
	state : {

	},
	mutations : {
	},
	actions : {
	},
	getters: {
		findOrFail: (state) => (obj, path) => {
        if (_.isEmpty(obj) || !path.length) {
          return null;
        }
        let pathArr = path.split('.');
        for (let i=0; i < pathArr.length; i++ ) {
          if (_.isUndefined(obj[pathArr[i]])) {
            return null;
          } else {
            obj = obj[pathArr[i]];
          }
        }
        return obj;      
      },
	}
}