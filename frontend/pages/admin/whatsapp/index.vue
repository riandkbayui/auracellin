<script type="text/javascript" setup>
import Breadcrumb from "@/components/main/breadcrumb";
import Error from "@/components/main/error";
</script>

<template>
	<div>
		<Breadcrumb title="Whatsapp" :pages="['Admin Area']" />

		<div class="card">
			<div class="card-header">
				<h5 class="card-title text-primary">Scan QR Code!</h5>
			</div>
			<div class="card-body bg-light">
				<div>
					<div class="d-flex justify-content-center">
						<div id="device-status" class="d-grid border-dark position-relative text-center wh-256">
							<div v-show="wa_status=='loading'" class="m-auto">
								<i class="fa fa-spinner text-black fa-spin fs-1"></i>
							</div>
							<div v-show="wa_status=='connected'">
								<img src="/assets/images/connected.png" class="w-100">
							</div>
							<div v-show="wa_status=='qrcode'" id="qrcode"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<div v-show="buttons.restart || buttons.logout" class="d-flex gap-2 justify-content-center">
					<button v-show="buttons.restart" v-on:click="clickRestart" class="btn btn-sm btn-warning"><i class="mdi mdi-refresh"></i> Restart</button>
					<button v-show="buttons.logout" v-on:click="clickLogout" class="btn btn-sm btn-danger"><i class="mdi mdi-logout"></i> Logout</button>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h5 class="card-title text-primary">Logs</h5>
			</div>
			<div class="card-body">
				<div>
					<ul id="logs" class="overflow-auto ht-200">

					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	layout: "member/default",
	data() {
		return {
			wa_status: "loading",
			buttons: {
				restart: false,
				logout: false
			},
			// botwa_url: `http://localhost:5000/m/default`,
			botwa_url: `https://starcommunity.id/wa`,
		}
	},
	mounted() {
		if (typeof jQuery !== "undefined") {
			this.getLogs();
		}
	},
	methods: {
		writeLog(str) {
			const li = document.createElement('li');
			li.innerText = `[${this.$moment().format('DD/MM/YYYY HH:mm:ss')}] ${str}`;
			document.querySelector('#logs').prepend(li);
		},
		async getLogs() {
			try {
				this.writeLog("start to connect");
				const { data: response } = await this.$axios.get(`${this.botwa_url}/home`);
				this.buttons.restart = true;

				var source = new EventSource(`${this.botwa_url}/logs`);
				source.onmessage = event => {
					const jsdata = JSON.parse(event.data);
					this.writeLog(jsdata.message);
					switch (jsdata.event) {
						case 'init':
							this.wa_status = "loading";
							break;
						case 'qr':
							this.buttons.logout = false;
							this.wa_status = "qrcode";
							document.querySelector('#qrcode').innerHTML = '';
							new QRCode(document.getElementById("qrcode"), {
								text: jsdata.qrcode,
								width: 256,
								height: 256,
								colorDark: "#000000",
								colorLight: "#ffffff",
								correctLevel: QRCode.CorrectLevel.L
							});
							break;
						case 'ready':
							this.buttons.logout = true;
							this.wa_status = "connected";
							break;
					}
				}
			} catch (err) {
				console.log(err);
				let err_msg = '';
				if (err.response) {
					err_msg = err.response.data.message;
				} else {
					err_msg = err.toString();
				}
				
				this.writeLog(err_msg);
			}
		},
		async clickRestart() {
			try {
				this.writeLog("restart device");
				this.wa_status = "loading";
				const { data: response } = await this.$axios.get(`${this.botwa_url}/restart`);
			} catch (err) {
				console.log(err);
				let err_msg = '';
				if (err.response) {
					err_msg = err.response.data.message;
				} else {
					err_msg = err.toString();
				}
				
				this.writeLog(err_msg);
			}
		},
		async clickLogout() {
			try {
				this.writeLog("logout device");
				this.wa_status = "loading";
				const { data: response } = await this.$axios.get(`${this.botwa_url}/logout`);
			} catch (err) {
				console.log(err);
				let err_msg = '';
				if (err.response) {
					err_msg = err.response.data.message;
				} else {
					err_msg = err.toString();
				}
				
				this.writeLog(err_msg);
			}
		},
	}
}
</script>