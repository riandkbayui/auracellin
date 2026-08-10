<template>
	<div>
        <form action="" v-on:submit.prevent="form_submit" method="post">
            <div class="card">
                <div class="card-body">
                    
                    <div class="text-center mb-3">
                        <div class="d-inline-block mb-2">
                            <div class="wh-72 rounded-circle bg-warning bg-soft d-flex justify-content-center align-items-center">
                                <i class="mdi mdi-text-box fsz-32 text-primary"></i>
                            </div>
                        </div>

                        <h5 class="text-primary">{{ form.name }}</h5>
                    </div>

                    <ul class="list-unstyled m-0 p-0">
                        <li v-for="(item, index) in form.fields" :key="index">
                            <div class="form-group">
                                <label>{{ item.key }}</label>
                                <input v-model="item.val" :placeholder="`Masukkan ${String(item.key).toLowerCase()}`" value="" class="form-control" type="text" autocomplete="off" required>
                            </div>
                        </li>
                    </ul>

                </div>
                <div class="card-footer">
                    <button class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </form>
	</div>
</template>

<script>
export default {
	layout: "auth",
    async asyncData({$axios, params, error}) {
        try {
            const { data: response } = await $axios.get(`form/${params.slug}`);
            return response;
        } catch (err) {
            console.log(err);
            let err_msg = '';
            if (err.response) {
                err_msg = err.response.data.message;
            } else {
                err_msg = err.toString();
            }
            error({statusCode: 404, message: err_msg});
        }
    },
    methods: {
        form_submit() {
            try {
                let str = ``;
                if(this.form.text_start.length > 0) {
                    str += `${this.form.text_start}

`;
                }
                for(const {key, val} of this.form.fields) {
				str += `${key}: *${val}*
`;
                }
                if(this.form.text_end.length > 0) {
                    str += `
${this.form.text_end}`;
                }
                const phone = this.form.phone;
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                const baseUrl = isMobile ? 'https://api.whatsapp.com/send/' : 'https://web.whatsapp.com/send';
                const url = `${baseUrl}?text=${encodeURIComponent(str)}&phone=${phone}`;
                location.href = url;
            } catch (error) {
                Swal.fire('Maaf!', String(error), 'error');
            }
        }
    }
};
</script>
