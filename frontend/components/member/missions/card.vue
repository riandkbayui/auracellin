<template>
	<div class="card">
		<div class="card-body">
			<div class="d-flex">
				<div class="flex-grow-1">
					<div class="text-center">
						<div class="d-inline-block mb-2">
							<div class="avatar-md ar-1-1 rounded-circle bg-info bg-soft d-flex justify-content-center align-items-center">
								<i class="mdi mdi-clock fsz-32"></i>
							</div>
						</div>
                        <h5 class="text-primary">{{ item.process }}</h5>
                        <div>Proses</div>
					</div>
				</div>
				<div class="flex-grow-1">
					<div class="text-center">
						<div class="d-inline-block mb-2">
							<div class="avatar-md ar-1-1 rounded-circle bg-success bg-soft d-flex justify-content-center align-items-center">
								<i class="mdi mdi-check fsz-32"></i>
							</div>
						</div>
                        <h5 class="text-primary">{{ item.success }}</h5>
                        <div>Berhasil</div>
					</div>
				</div>
				<div class="flex-grow-1">
					<div class="text-center">
						<div class="d-inline-block mb-2">
							<div class="avatar-md ar-1-1 rounded-circle bg-warning bg-soft d-flex justify-content-center align-items-center">
								<i class="mdi mdi-cube fsz-32"></i>
							</div>
						</div>
                        <h5 class="text-primary">{{ item.total }}</h5>
                        <div>Total</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
    export default {
        data() {
            return {
                item: {
                    process: 0,
                    success: 0,
                    total: 0,
                }
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            async getData() {
                try {
                    const { data: response } = await this.$axios.get(`member/missions/card`);
                    this.item = response.item;
                } catch (err) {
                    console.log(err);
                    let err_msg = '';
                    if (err.response) {
                        err_msg = err.response.data.message;
                    } else {
                        err_msg = err.toString();
                    }
                    this.err = err_msg;
                }
            }
        }
    }
</script>
