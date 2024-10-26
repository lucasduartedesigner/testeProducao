<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>

	var Delta = Quill.import('delta');

	var quill = new Quill('#editor-container', {
	  modules: {
		toolbar: [
				  ['bold', 'italic'],
			 	  [
					  { align: '' }, 
					  { align: 'center' }, 
					  { align: 'right' }, 
					  { align: 'justify' }
				  ],
				  ['link', 'blockquote', 'code-block', 'image'],
				  [
					  { list: 'ordered' }, 
					  { list: 'bullet' },
					  { 'script': 'sub'}, 
					  { 'script': 'super' }
				  ]
				 ]
	  },
	  theme: 'snow'
	});
</script>