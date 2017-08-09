<template src="./loginRegister.html"></template>
<script>
export default {
  name: "login_register",
  data: () => ({
    gender: null,
  })
}
</script>
<style lang="scss" scoped>
a{
  color: #00d1b2;

}
a:hover{
  color: #fff;
}
.block{
  &.with-panel{
    background-color: #fff;
    padding: 7px;
    border-radius: 3px;
    box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
  }
}
</style>
