import moment from 'moment';

export default function(context, inject) {

	inject('user', function (...keys) {
		try {
			let data = context.store.getters.getUser;
			for (const key of keys) {
				data = data?.[key];
				if (data === undefined) break;
			}
			return data ?? '';
		} catch (e) {
			console.error(e);
			return '';
		}
	});

	inject(`config`, function(key){
		try {
			return context.store.getters.getConfigs[key];
		} catch(e) {
			console.log(e);
			return '';
		}
	});

	inject(`packages`, function(){
		try {
			return context.store.getters.getPackages;
		} catch(e) {
			console.log(e);
			return '';
		}
	});

	inject(`getNested`, function(obj, keys = [], defaultValue = ''){
		try {
			return keys.reduce((acc, key) => {
				return acc && acc.hasOwnProperty(key) ? acc[key] : undefined;
			}, obj) ?? defaultValue;
		} catch(e) {
			console.log(e);
			return defaultValue;
		}
	});

	inject(`moment`, moment);

	inject(`idr`, function(val, prefix=""){
		try {
			val.toString().replace(/[^0-9]/gi, '');
			val = Number.parseInt(val);
			val = isNaN(val) ? 0 : val;
			const formated = Intl.NumberFormat().format(val).replaceAll(',', '.');
			if(prefix == "") {
				return formated;
			} else {
				return `${prefix}${formated}`;
			}
		} catch(e) {
			console.log(e);
			return '';
		}
	});

	inject(`badge`, function(status, options) {
		try {
			const match = options.find(opt => opt.value.toLowerCase() == status.toLowerCase());
			if (match) {
				return `<span class="${match.class}">${match.label}</span>`;
			}
			return `<span class="badge badge-secondary">${status}</span>`;
		} catch (error) {
			return status;
		}
	});

}