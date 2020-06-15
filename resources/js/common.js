var CommonJs = {
  page: {items: '', rowCount: 0, numberPerPage: 20, pageNumber: 1, pageList: [], pageCount: 0},
  getPageCount (pageResult) {
    console.log('rowCount là:'+pageResult.rowCount)
    console.log('numberPerPage là:'+pageResult.numberPerPage)
    const pageCount = Math.ceil(pageResult.rowCount / pageResult.numberPerPage)
    console.log('số page là:'+pageCount)
    return pageCount
  },
  getPageList (pagingResult) {
    console.log('gọi vào hàm getPageList tại file common.js '+pagingResult)
    const pages = []
    let from = pagingResult.pageNumber - 3
    let to = pagingResult.pageNumber + 5
    if (from < 0) {
      to -= from
      from = 1
    }

    if (from < 1) {
      from = 1
    }

    if (to > pagingResult.pageCount) {
      to = pagingResult.pageCount
    }

    for (let i = from; i <= to; i++) {
      pages.push(i)
    }
    console.log('from = '+from)
    console.log('to = '+to)
    console.log('pages = '+pages)
    console.log('pageCount = '+pagingResult.pageCount)
    return pages
  }
}

export default CommonJs

// /*KHU VỰC PHÂN TRANG JAVASCRIPT*/
// const page = {items: '', rowCount: 0, numberPerPage: 20, pageNumber: 1, pageList: [], pageCount: 0}
//
// /*load tong trang va danh sach trang*/
// function getPageCount (pageResult) {
//   alert('gọi vào hàm getPageCount tại file common.js')
//   const pageCount = Math.ceil(pageResult.rowCount / pageResult.numberPerPage)
//   return pageCount
// }
//
// /*TRợ giúp tính toán số trang hiển thị khi hiện page*/
// function getPageList (pagingResult) {
//   alert('gọi vào hàm getPageList tại file common.js')
//   const pages = []
//   let from = pagingResult.pageNumber - 3
//   let to = pagingResult.pageNumber + 5
//   if (from < 0) {
//     to -= from
//     from = 1
//   }
//
//   if (from < 1) {
//     from = 1
//   }
//
//   if (to > pagingResult.pageCount) {
//     to = pagingResult.pageCount
//   }
//
//   for (let i = from; i <= to; i++) {
//     pages.push(i)
//   }
//   return pages
// }
