<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">

            <router-view></router-view>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/toni/developments/testes/orbital/resources/views/home.blade.php ENDPATH**/ ?>