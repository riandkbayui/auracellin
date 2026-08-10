<script type="text/javascript">
    export default {
        async asyncData({$axios, redirect, error}) {
            try {
                const { data: response } = await $axios.get(`auth/logout`);
                redirect('/auth/login');
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
        }
    }
</script>