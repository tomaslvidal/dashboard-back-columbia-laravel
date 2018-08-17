<template>
	<div class="columbia">
		<nav-component></nav-component>

		<div class="content-wrapper">
			<div class="container-fluid">
				<breadcrumb></breadcrumb>

				<div class="col-md-12">
					<div class="row">
						<slot/>
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