<template>
	<div class="columbia">		
		<nav-component></nav-component>

		<div class="content-wrapper">
			<div class="container-fluid">
				<breadcrumb></breadcrumb>

				<div class="row separation">
					<div class="col-12">
						<b-container fluid>
							<slot/>
						</b-container>
					</div>
				</div>

				<footer class="sticky-footer">
				  <div class="container">
				    <div class="text-center">
				      <small>Copyright © Columbria 2018</small>
				    </div>
				  </div>
				</footer>
			</div>
		</div>

		<modal-logout/>
	</div>
</template>

<script>
export default{
	beforeCreate(){
		let body = document.querySelector('body');

		body.className += ' fixed-nav sticky-footer bg-dark';

		body.setAttribute('id', 'page-top');
	}
}
</script>

<style>
	.row.separation{
		margin-bottom: 20px;
	}
</style>