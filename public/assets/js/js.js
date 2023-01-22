//prettier-ignore
function updateDeskripsi(value, id) {
    $.ajax({
        url: '/update-deskripsi/' + id + '?value='+value,
        type: 'get',
        success: function (result) {},
    });
}
//prettier-ignore
function updateLink(value, id) {
    $.ajax({
        url: '/update-link/' + id + '?value='+value,
        type: 'get',
        success: function (result) {},
    });
}
//prettier-ignore
function deleteAttach(id) {
    $.ajax({
        url: '/delete-attach/' + id,
        type: 'get',
        success: function (result) {
            window.location.reload()
        },
    });
}

//prettier-ignore
function deleteWisata(id) {
    Swal.fire({
        title: 'Hapus Objek Wisata?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          window.location.replace('/hapus-objek?id='+id)
        }
      })
}
