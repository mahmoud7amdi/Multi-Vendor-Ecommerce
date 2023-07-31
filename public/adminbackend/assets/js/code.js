$(function(){
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


        Swal.fire({
            title: 'Are you sure?',
            text: "Delete This Data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })


    });

});


//confirm order
// $(function(){
//     $(document).on('click','#confirm',function(e){
//         e.preventDefault();
//         var link = $(this).attr("href");
//
//
//         Swal.fire({
//             title: 'Are you sure to confirm ?',
//             text: "You will not be able to pending again ?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Yes, confirm it !'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 window.location.href = link
//                 Swal.fire(
//                     'confirm!',
//                     ' confirmed change',
//                     'success'
//                 )
//             }
//         })
//
//
//     });
//
// });
//
//
//
//
// $(function(){
//     $(document).on('click','#processing',function(e){
//         e.preventDefault();
//         var link = $(this).attr("href");
//
//
//         Swal.fire({
//             title: 'Are you sure to processing ?',
//             text: "You will not be able to pending again ?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Yes, processing !'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 window.location.href = link
//                 Swal.fire(
//                     'processing!',
//                     ' processing change',
//                     'success'
//                 )
//             }
//         })
//
//
//     });
//
// });
//
//
//
//
//
//
// $(function(){
//     $(document).on('click','#delivered',function(e){
//         e.preventDefault();
//         var link = $(this).attr("href");
//
//
//         Swal.fire({
//             title: 'Are you sure to delivered ?',
//             text: "You will not be able to pending again ?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Yes, delivered !'
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 window.location.href = link
//                 Swal.fire(
//                     'delivered!',
//                     'delivered change',
//                     'success'
//                 )
//             }
//         })
//
//
//     });
//
// });
