module.exports = async (ctx, next)=>{
  try{
    await next();
  }catch(e){
    let status = e.status || 500;

    if(status == 500) console.error(e); // 500 이면 에러로그 출력

    ctx.status = status;
    ctx.body = {
      status: status,
      msg: status == 500 ? "서버 에러" : e.message
    }
  }
}

// node에서 에러 테스트하는 친구
// app.use 안에 넣고 테스트하면됨 
// 럽핑계형님의 프로그램
