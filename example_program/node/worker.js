function timedCount() {
    postMessage('test');
    setTimeout('timedCount()', 1000);
  }
  
  timedCount();
  
  // 웹워커 종료
  
  function stopWorker() {
    w.terminate();
    w = undefined;
}