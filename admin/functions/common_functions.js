// const DOCUMENTS_BASE_URL = '/LYNX/documentos/';

// async function uploadFiles(file, field, id, url) { 
//     const formDataFile = new FormData();
//     formDataFile.append('file', file);
//     formDataFile.append(field, id);
//     return await fetch(url, {method: 'post', body: formDataFile });
// }

// async function saveStudentsGroup(url, id_alumno, id_grupo) { 
//     const formDataFile = new FormData();
//     formDataFile.append('id_alumno', id_alumno);
//     formDataFile.append('id_grupo', id_grupo);
//     return await fetch(url, {method: 'post', body: formDataFile });
// }

// function openLocalFile(file) {
//     const url = URL.createObjectURL(file);
//     window.open(url);
// };

// function openServerFile(url = '') {
//     const [fileName] = (url?.split('/') ?? [])?.slice(-1) ?? [];
//     if(!fileName) return;
//     window.open(window.origin + DOCUMENTS_BASE_URL + fileName);	
// }

// // function updateSubmitButton(pending = false, button) {
// //     button?.classList?.[pending ? 'add' : 'remove']('disabled');
// //     if(pending) button.setAttribute('disabled', true)
// //     else button.removeAttribute('disabled')
// // }
