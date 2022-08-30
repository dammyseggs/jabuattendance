<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="mymodal" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">
          <div class="head">
            <div class="title">Attendance System</div>
            <button class="close-x"  @click="close" aria-label="Close modal">X</button>
          </div>
          <section class="modal-body">
            <slot name="body">
              
            </slot>             
          </section>
          <div class="foot">
             <button class="btn btn-primary" @click="yes" >Yes</button>
             <button class="btn btn-danger" @click="close" aria-label="Close modal">No</button>

          </div>
      </div>
  
      <!-- <div class="modal"
        role="dialog" aria-labelledby="modalTitle" aria-describedby="modalDescription">
        <header class="modal-header" id="modalTitle" >
          <slot name="header">
            This is the default tile!
          </slot>
          <button type="button" class="btn-close" @click="close" aria-label="Close modal">x</button>
        </header>

        <section class="modal-body" id="modalDescription" >
          <slot name="body">
            This is the default body!
          </slot>
        </section>

        
      </div> -->
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'Modal',
    methods: {
      close() {
        this.$emit('close');
      },

      yes() {
        this.$emit('yes');
      },
    },
  };
</script>

<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    background-color: rgba(0, 0, 0, 0.7);
   /* bottom: 0;
    left: 0;
    right: 0; */
    /* */
    display: flex;
    justify-content: center;
    align-items: center; 
  }

  .mymodal{
    /* position: absolute;
    top: 10%;
    left: 50%; */
    background-color: #e4e1e1;
    box-shadow: 2px 2px 20px 1px;
    width: 30%;
  }

  .title{
    font-weight: 800;
  }

  .foot, .head{
    background-color:rgba(43, 58, 74, 0.9); 
    display: flex;  
  }

  .head{
      justify-content: space-between;
      padding: 5px 10px;
  }

  .foot{
      justify-content: center;
      padding: 5px;
  }

  .close-x{
      width:  30px;
      height: 30px;
      background-color:rgb(184, 77, 77);
      border-radius:25px;
      box-shadow:1px 1px 1px #565656;
      position:relative;
      transition:all .2s;
  }

  .close-x:hover{
    background-color:darken(darkseagreen, 10%);
    cursor:pointer;
  }

  .foot button{
    margin-left: 5px;
  }

  .modal-header,.modal-footer {
    display: flex;
    background-color:#d6772e
  }
  
  

  /*

  

  .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #4AAE9B;
    background: transparent;
  } */

  /* .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  } */
</style>