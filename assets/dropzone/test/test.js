(function(){chai.should(),describe("Dropzone",function(){var e;return function(){return{name:"test file name",size:123456,type:"text/html"}},e=null,beforeEach(function(){return e=sinon.useFakeXMLHttpRequest()}),describe("static functions",function(){return describe("Dropzone.createElement()",function(){var e;return e=Dropzone.createElement('<div class="test"><span>Hallo</span></div>'),it("should properly create an element from a string",function(){return e.tagName.should.equal("DIV")}),it("should properly add the correct class",function(){return e.classList.contains("test").should.be.ok}),it("should properly create child elements",function(){return e.querySelector("span").tagName.should.equal("SPAN")}),it("should always return only one element",function(){return(e=Dropzone.createElement("<div></div><span></span>")).tagName.should.equal("DIV")})}),describe("Dropzone.elementInside()",function(){var e,t,n;return n=Dropzone.createElement('<div id="test"><div class="child1"><div class="child2"></div></div></div>'),document.body.appendChild(n),e=n.querySelector(".child1"),t=n.querySelector(".child2"),after(function(){return document.body.removeChild(n)}),it("should return yes if elements are the same",function(){return Dropzone.elementInside(n,n).should.be.ok}),it("should return yes if element is direct child",function(){return Dropzone.elementInside(e,n).should.be.ok}),it("should return yes if element is some child",function(){return Dropzone.elementInside(t,n).should.be.ok,Dropzone.elementInside(t,document.body).should.be.ok}),it("should return no unless element is some child",function(){return Dropzone.elementInside(n,e).should.not.be.ok,Dropzone.elementInside(document.body,e).should.not.be.ok})}),describe("Dropzone.optionsForElement()",function(){var e,t;return t={url:"/some/url",method:"put"},before(function(){return Dropzone.options.testElement=t}),after(function(){return delete Dropzone.options.testElement}),e=document.createElement("div"),it("should take options set in Dropzone.options from camelized id",function(){return e.id="test-element",Dropzone.optionsForElement(e).should.equal(t)}),it("should return undefined if no options set",function(){return e.id="test-element2",expect(Dropzone.optionsForElement(e)).to.equal(void 0)})}),describe("Dropzone.forElement()",function(){var e,t;return t=document.createElement("div"),t.id="some-test-element",e=null,before(function(){return document.body.appendChild(t),e=new Dropzone(t,{url:"/test"})}),after(function(){return e.disable(),document.body.removeChild(t)}),it("should throw an exception if no dropzone attached",function(){return expect(function(){return Dropzone.forElement(document.createElement("div"))}).to.throw("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.")}),it("should accept css selectors",function(){return expect(Dropzone.forElement("#some-test-element")).to.equal(e)}),it("should accept native elements",function(){return expect(Dropzone.forElement(t)).to.equal(e)})}),describe("Dropzone.discover()",function(){var e,t,n;return e=document.createElement("div"),e.className="dropzone",t=e.cloneNode(),n=e.cloneNode(),e.id="test-element-1",t.id="test-element-2",n.id="test-element-3",describe("specific options",function(){return before(function(){return Dropzone.options.testElement1={url:"test-url"},Dropzone.options.testElement2=!1,document.body.appendChild(e),document.body.appendChild(t),Dropzone.discover()}),after(function(){return document.body.removeChild(e),document.body.removeChild(t)}),it("should find elements with a .dropzone class",function(){return e.dropzone.should.be.ok}),it("should not create dropzones with disabled options",function(){return expect(t.dropzone).to.not.be.ok})}),describe("Dropzone.autoDiscover",function(){return before(function(){return Dropzone.options.testElement3={url:"test-url"},document.body.appendChild(n)}),after(function(){return document.body.removeChild(n)}),it("should create dropzones even if Dropzone.autoDiscover == false",function(){return Dropzone.autoDiscover=!1,Dropzone.discover(),expect(n.dropzone).to.be.ok}),it("should not automatically be called if Dropzone.autoDiscover == false",function(){return Dropzone.autoDiscover=!1,Dropzone.discover=function(){return expect(!1).to.be.ok},Dropzone._autoDiscoverFunction()})})}),describe("Dropzone.isValidFile()",function(){return it("should return true if called without acceptedFiles",function(){return Dropzone.isValidFile({type:"some/type"},null).should.be.ok}),it("should properly validate if called with concrete mime types",function(){var e;return e="text/html,image/jpeg,application/json",Dropzone.isValidFile({type:"text/html"},e).should.be.ok,Dropzone.isValidFile({type:"image/jpeg"},e).should.be.ok,Dropzone.isValidFile({type:"application/json"},e).should.be.ok,Dropzone.isValidFile({type:"image/bmp"},e).should.not.be.ok}),it("should properly validate if called with base mime types",function(){var e;return e="text/*,image/*,application/*",Dropzone.isValidFile({type:"text/html"},e).should.be.ok,Dropzone.isValidFile({type:"image/jpeg"},e).should.be.ok,Dropzone.isValidFile({type:"application/json"},e).should.be.ok,Dropzone.isValidFile({type:"image/bmp"},e).should.be.ok,Dropzone.isValidFile({type:"some/type"},e).should.not.be.ok}),it("should properly validate if called with mixed mime types",function(){var e;return e="text/*,image/jpeg,application/*",Dropzone.isValidFile({type:"text/html"},e).should.be.ok,Dropzone.isValidFile({type:"image/jpeg"},e).should.be.ok,Dropzone.isValidFile({type:"image/bmp"},e).should.not.be.ok,Dropzone.isValidFile({type:"application/json"},e).should.be.ok,Dropzone.isValidFile({type:"some/type"},e).should.not.be.ok}),it("should properly validate even with spaces in between",function(){var e;return e="text/html ,   image/jpeg, application/json",Dropzone.isValidFile({type:"text/html"},e).should.be.ok,Dropzone.isValidFile({type:"image/jpeg"},e).should.be.ok}),it("should properly validate extensions",function(){var e;return e="text/html ,    image/jpeg, .pdf  ,.png",Dropzone.isValidFile({name:"somxsfsd",type:"text/html"},e).should.be.ok,Dropzone.isValidFile({name:"somesdfsdf",type:"image/jpeg"},e).should.be.ok,Dropzone.isValidFile({name:"somesdfadfadf",type:"application/json"},e).should.not.be.ok,Dropzone.isValidFile({name:"some-file file.pdf",type:"random/type"},e).should.be.ok,Dropzone.isValidFile({name:"some-file.pdf file.gif",type:"random/type"},e).should.not.be.ok,Dropzone.isValidFile({name:"some-file file.png",type:"random/type"},e).should.be.ok})}),describe("Dropzone.confirm",function(){return beforeEach(function(){return sinon.stub(window,"confirm")}),afterEach(function(){return window.confirm.restore()}),it("should forward to window.confirm and call the callbacks accordingly",function(){var e,t;return e=t=!1,window.confirm.returns(!0),Dropzone.confirm("test question",function(){return e=!0},function(){return t=!0}),window.confirm.args[0][0].should.equal("test question"),e.should.equal(!0),t.should.equal(!1),e=t=!1,window.confirm.returns(!1),Dropzone.confirm("test question 2",function(){return e=!0},function(){return t=!0}),window.confirm.args[1][0].should.equal("test question 2"),e.should.equal(!1),t.should.equal(!0)}),it("should not error if rejected is not provided",function(){var e;return e=!1,window.confirm.returns(!1),Dropzone.confirm("test question",function(){return e=!0}),window.confirm.args[0][0].should.equal("test question"),e.should.equal(!1),(!1).should.equal(!1)})})}),describe("Dropzone.getElement() / getElements()",function(){var e;return e=[],beforeEach(function(){return(e=[]).push(Dropzone.createElement('<div class="tmptest"></div>')),e.push(Dropzone.createElement('<div id="tmptest1" class="random"></div>')),e.push(Dropzone.createElement('<div class="random div"></div>')),e.forEach(function(e){return document.body.appendChild(e)})}),afterEach(function(){return e.forEach(function(e){return document.body.removeChild(e)})}),describe(".getElement()",function(){return it("should accept a string",function(){return Dropzone.getElement(".tmptest").should.equal(e[0]),Dropzone.getElement("#tmptest1").should.equal(e[1])}),it("should accept a node",function(){return Dropzone.getElement(e[2]).should.equal(e[2])}),it("should fail if invalid selector",function(){var e;return e="Invalid `clickable` option provided. Please provide a CSS selector or a plain HTML element.",expect(function(){return Dropzone.getElement("lblasdlfsfl","clickable")}).to.throw(e),expect(function(){return Dropzone.getElement({lblasdlfsfl:"lblasdlfsfl"},"clickable")}).to.throw(e),expect(function(){return Dropzone.getElement(["lblasdlfsfl"],"clickable")}).to.throw(e)})}),describe(".getElements()",function(){return it("should accept a list of strings",function(){return Dropzone.getElements([".tmptest","#tmptest1"]).should.eql([e[0],e[1]])}),it("should accept a list of nodes",function(){return Dropzone.getElements([e[0],e[2]]).should.eql([e[0],e[2]])}),it("should accept a mixed list",function(){return Dropzone.getElements(["#tmptest1",e[2]]).should.eql([e[1],e[2]])}),it("should accept a string selector",function(){return Dropzone.getElements(".random").should.eql([e[1],e[2]])}),it("should accept a single node",function(){return Dropzone.getElements(e[1]).should.eql([e[1]])}),it("should fail if invalid selector",function(){var e;return e="Invalid `clickable` option provided. Please provide a CSS selector, a plain HTML element or a list of those.",expect(function(){return Dropzone.getElements("lblasdlfsfl","clickable")}).to.throw(e),expect(function(){return Dropzone.getElements(["lblasdlfsfl"],"clickable")}).to.throw(e)})})}),describe("constructor()",function(){var e;return e=null,afterEach(function(){if(null!=e)return e.destroy()}),it("should throw an exception if the element is invalid",function(){return expect(function(){return e=new Dropzone("#invalid-element")}).to.throw("Invalid dropzone element.")}),it("should throw an exception if assigned twice to the same element",function(){var t;return t=document.createElement("div"),e=new Dropzone(t,{url:"url"}),expect(function(){return new Dropzone(t,{url:"url"})}).to.throw("Dropzone already attached.")}),it("should throw an exception if both acceptedFiles and acceptedMimeTypes are specified",function(){var t;return t=document.createElement("div"),expect(function(){return e=new Dropzone(t,{url:"test",acceptedFiles:"param",acceptedMimeTypes:"types"})}).to.throw("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.")}),it("should set itself as element.dropzone",function(){var t;return t=document.createElement("div"),e=new Dropzone(t,{url:"url"}),t.dropzone.should.equal(e)}),it("should use the action attribute not the element with the name action",function(){var t;return t=Dropzone.createElement('<form action="real-action"><input type="hidden" name="action" value="wrong-action" /></form>'),(e=new Dropzone(t)).options.url.should.equal("real-action")}),describe("options",function(){var t,n;return t=null,n=null,beforeEach(function(){return t=document.createElement("div"),t.id="test-element",n=document.createElement("div"),n.id="test-element2",Dropzone.options.testElement={url:"/some/url",parallelUploads:10}}),afterEach(function(){return delete Dropzone.options.testElement}),it("should take the options set in Dropzone.options",function(){return(e=new Dropzone(t)).options.url.should.equal("/some/url"),e.options.parallelUploads.should.equal(10)}),it("should prefer passed options over Dropzone.options",function(){return(e=new Dropzone(t,{url:"/some/other/url"})).options.url.should.equal("/some/other/url")}),it("should take the default options if nothing set in Dropzone.options",function(){return(e=new Dropzone(n,{url:"/some/url"})).options.parallelUploads.should.equal(2)}),it("should call the fallback function if forceFallback == true",function(n){return e=new Dropzone(t,{url:"/some/other/url",forceFallback:!0,fallback:function(){return n()}})}),it("should set acceptedFiles if deprecated acceptedMimetypes option has been passed",function(){return(e=new Dropzone(t,{url:"/some/other/url",acceptedMimeTypes:"my/type"})).options.acceptedFiles.should.equal("my/type")}),describe("options.clickable",function(){var n;return n=null,e=null,beforeEach(function(){return n=document.createElement("div"),n.className="some-clickable",document.body.appendChild(n)}),afterEach(function(){if(document.body.removeChild(n),null!=e)return e.destroy}),it("should use the default element if clickable == true",function(){return(e=new Dropzone(t,{clickable:!0})).clickableElements.should.eql([e.element])}),it("should lookup the element if clickable is a CSS selector",function(){return(e=new Dropzone(t,{clickable:".some-clickable"})).clickableElements.should.eql([n])}),it("should simply use the provided element",function(){return(e=new Dropzone(t,{clickable:n})).clickableElements.should.eql([n])}),it("should accept multiple clickable elements",function(){return(e=new Dropzone(t,{clickable:[document.body,".some-clickable"]})).clickableElements.should.eql([document.body,n])}),it("should throw an exception if the element is invalid",function(){return expect(function(){return e=new Dropzone(t,{clickable:".some-invalid-clickable"})}).to.throw("Invalid `clickable` option provided. Please provide a CSS selector, a plain HTML element or a list of those.")})})})}),describe("init()",function(){return describe("clickable",function(){var e,t,n,o;t={"using acceptedFiles":new Dropzone(Dropzone.createElement('<form action="/"></form>'),{clickable:!0,acceptedFiles:"audio/*,video/*"}),"using acceptedMimeTypes":new Dropzone(Dropzone.createElement('<form action="/"></form>'),{clickable:!0,acceptedMimeTypes:"audio/*,video/*"})},it("should not add an accept attribute if no acceptParameter",function(){return new Dropzone(Dropzone.createElement('<form action="/"></form>'),{clickable:!0,acceptParameter:null,acceptedMimeTypes:null}).hiddenFileInput.hasAttribute("accept").should.be.false}),o=[];for(n in t)e=t[n],o.push(describe(n,function(){return function(e){return it("should create a hidden file input if clickable",function(){return e.hiddenFileInput.should.be.ok,e.hiddenFileInput.tagName.should.equal("INPUT")}),it("should use the acceptParameter",function(){return e.hiddenFileInput.getAttribute("accept").should.equal("audio/*,video/*")}),it("should create a new input element when something is selected to reset the input field",function(){var t,n,o,l;for(l=[],o=0;o<=3;++o)n=e.hiddenFileInput,(t=document.createEvent("HTMLEvents")).initEvent("change",!0,!0),n.dispatchEvent(t),e.hiddenFileInput.should.not.equal(n),l.push(Dropzone.elementInside(n,document).should.not.be.ok);return l})}(e)}));return o}),it("should create a .dz-message element",function(){var e;return e=Dropzone.createElement('<form class="dropzone" action="/"></form>'),new Dropzone(e,{clickable:!0,acceptParameter:null,acceptedMimeTypes:null}),e.querySelector(".dz-message").should.be.instanceof(Element)}),it("should not create a .dz-message element if there already is one",function(){var e,t;return e=Dropzone.createElement('<form class="dropzone" action="/"></form>'),t=Dropzone.createElement('<div class="dz-message">TEST</div>'),e.appendChild(t),new Dropzone(e,{clickable:!0,acceptParameter:null,acceptedMimeTypes:null}),e.querySelector(".dz-message").should.equal(t),e.querySelectorAll(".dz-message").length.should.equal(1)})}),describe("options",function(){var e,t;return t=null,e=null,beforeEach(function(){return t=Dropzone.createElement("<div></div>"),e=new Dropzone(t,{maxFilesize:4,url:"url",acceptedMimeTypes:"audio/*,image/png",maxFiles:3})}),describe("file specific",function(){var t;return t=null,beforeEach(function(){return t={name:"test name",size:2e6},e.options.addedfile.call(e,t)}),describe(".addedFile()",function(){return it("should properly create the previewElement",function(){return t.previewElement.should.be.instanceof(Element),t.previewElement.querySelector("[data-dz-name]").innerHTML.should.eql("test name"),t.previewElement.querySelector("[data-dz-size]").innerHTML.should.eql("<strong>2</strong> MB")})}),describe(".error()",function(){return it("should properly insert the error",function(){return e.options.error.call(e,t,"test message"),t.previewElement.querySelector("[data-dz-errormessage]").innerHTML.should.eql("test message")})}),describe(".thumbnail()",function(){return it("should properly insert the error",function(){var n,o;return o="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==",e.options.thumbnail.call(e,t,o),(n=t.previewElement.querySelector("[data-dz-thumbnail]")).src.should.eql(o),n.alt.should.eql("test name")})}),describe(".uploadprogress()",function(){return it("should properly set the width",function(){return e.options.uploadprogress.call(e,t,0),t.previewElement.querySelector("[data-dz-uploadprogress]").style.width.should.eql("0%"),e.options.uploadprogress.call(e,t,80),t.previewElement.querySelector("[data-dz-uploadprogress]").style.width.should.eql("80%"),e.options.uploadprogress.call(e,t,90),t.previewElement.querySelector("[data-dz-uploadprogress]").style.width.should.eql("90%"),e.options.uploadprogress.call(e,t,100),t.previewElement.querySelector("[data-dz-uploadprogress]").style.width.should.eql("100%")})})})}),describe("instance",function(){var t,n,o;return n=null,t=null,o=null,beforeEach(function(){return o=[],e.onCreate=function(e){return o.push(e)},n=Dropzone.createElement("<div></div>"),document.body.appendChild(n),t=new Dropzone(n,{maxFilesize:4,maxFiles:100,url:"url",acceptedMimeTypes:"audio/*,image/png",uploadprogress:function(){}})}),afterEach(function(){return document.body.removeChild(n),t.destroy(),e.restore()}),describe(".accept()",function(){return it("should pass if the filesize is OK",function(){return t.accept({size:2097152,type:"audio/mp3"},function(e){return expect(e).to.be.undefined})}),it("shouldn't pass if the filesize is too big",function(){return t.accept({size:10485760,type:"audio/mp3"},function(e){return e.should.eql("File is too big (10MB). Max filesize: 4MB.")})}),it("should properly accept files which mime types are listed in acceptedFiles",function(){return t.accept({type:"audio/mp3"},function(e){return expect(e).to.be.undefined}),t.accept({type:"image/png"},function(e){return expect(e).to.be.undefined}),t.accept({type:"audio/wav"},function(e){return expect(e).to.be.undefined})}),it("should properly reject files when the mime type isn't listed in acceptedFiles",function(){return t.accept({type:"image/jpeg"},function(e){return e.should.eql("You can't upload files of this type.")})}),it("should fail if maxFiles has been exceeded and call the event maxfilesexceeded",function(){var e,n;return sinon.stub(t,"getAcceptedFiles"),n={type:"audio/mp3"},t.getAcceptedFiles.returns({length:99}),e=!1,t.on("maxfilesexceeded",function(t){return t.should.equal(n),e=!0}),t.accept(n,function(e){return expect(e).to.be.undefined}),e.should.not.be.ok,t.getAcceptedFiles.returns({length:100}),t.accept(n,function(e){return expect(e).to.equal("You can only upload 100 files.")}),e.should.be.ok,t.getAcceptedFiles.restore()})}),describe(".removeFile()",function(){return it("should abort uploading if file is currently being uploaded",function(e){var n;return n={name:"test file name",size:123456,type:"text/html"},t.uploadFile=function(e){},t.accept=function(e,t){return t()},sinon.stub(t,"cancelUpload"),t.addFile(n),setTimeout(function(){return n.status.should.equal(Dropzone.UPLOADING),t.getUploadingFiles()[0].should.equal(n),t.cancelUpload.callCount.should.equal(0),t.removeFile(n),t.cancelUpload.callCount.should.equal(1),e()},10)})}),describe(".cancelUpload()",function(){return it("should properly cancel upload if file currently uploading",function(e){var n;return n={name:"test file name",size:123456,type:"text/html"},t.accept=function(e,t){return t()},t.addFile(n),setTimeout(function(){return n.status.should.equal(Dropzone.UPLOADING),t.getUploadingFiles()[0].should.equal(n),t.cancelUpload(n),n.status.should.equal(Dropzone.CANCELED),t.getUploadingFiles().length.should.equal(0),t.getQueuedFiles().length.should.equal(0),e()},10)}),it("should properly cancel the upload if file is not yet uploading",function(){var e;return e={name:"test file name",size:123456,type:"text/html"},t.accept=function(e,t){return t()},t.options.parallelUploads=0,t.addFile(e),e.status.should.equal(Dropzone.QUEUED),t.getQueuedFiles()[0].should.equal(e),t.cancelUpload(e),e.status.should.equal(Dropzone.CANCELED),t.getQueuedFiles().length.should.equal(0),t.getUploadingFiles().length.should.equal(0)}),it("should call processQueue()",function(e){var n;return n={name:"test file name",size:123456,type:"text/html"},t.accept=function(e,t){return t()},t.options.parallelUploads=0,sinon.spy(t,"processQueue"),t.addFile(n),setTimeout(function(){return t.processQueue.callCount.should.equal(1),t.cancelUpload(n),t.processQueue.callCount.should.equal(2),e()},10)}),it("should properly cancel all files with the same XHR if uploadMultiple is true",function(e){var n,o,l;return n={name:"test file name",size:123456,type:"text/html"},o={name:"test file name",size:123456,type:"text/html"},l={name:"test file name",size:123456,type:"text/html"},t.accept=function(e,t){return t()},t.options.uploadMultiple=!0,t.options.parallelUploads=3,sinon.spy(t,"processFiles"),t.addFile(n),t.addFile(o),t.addFile(l),setTimeout(function(){var r;return t.processFiles.callCount.should.equal(1),sinon.spy(n.xhr,"abort"),t.cancelUpload(n),expect(n.xhr===(r=o.xhr)&&r===l.xhr).to.be.ok,n.status.should.equal(Dropzone.CANCELED),o.status.should.equal(Dropzone.CANCELED),l.status.should.equal(Dropzone.CANCELED),n.xhr.abort.callCount.should.equal(1),e()},10)})}),describe(".disable()",function(){return it("should properly cancel all pending uploads",function(e){return t.accept=function(e,t){return t()},t.options.parallelUploads=1,t.addFile({name:"test file name",size:123456,type:"text/html"}),t.addFile({name:"test file name",size:123456,type:"text/html"}),setTimeout(function(){return t.getUploadingFiles().length.should.equal(1),t.getQueuedFiles().length.should.equal(1),t.files.length.should.equal(2),sinon.spy(o[0],"abort"),o[0].abort.callCount.should.equal(0),t.disable(),o[0].abort.callCount.should.equal(1),t.getUploadingFiles().length.should.equal(0),t.getQueuedFiles().length.should.equal(0),t.files.length.should.equal(2),t.files[0].status.should.equal(Dropzone.CANCELED),t.files[1].status.should.equal(Dropzone.CANCELED),e()},10)})}),describe(".destroy()",function(){return it("should properly cancel all pending uploads and remove all file references",function(e){return t.accept=function(e,t){return t()},t.options.parallelUploads=1,t.addFile({name:"test file name",size:123456,type:"text/html"}),t.addFile({name:"test file name",size:123456,type:"text/html"}),setTimeout(function(){return t.getUploadingFiles().length.should.equal(1),t.getQueuedFiles().length.should.equal(1),t.files.length.should.equal(2),sinon.spy(t,"disable"),t.destroy(),t.disable.callCount.should.equal(1),n.should.not.have.property("dropzone"),e()},10)}),it("should be able to create instance of dropzone on the same element after destroy",function(){return t.destroy(),function(){return new Dropzone(n,{maxFilesize:4,url:"url",acceptedMimeTypes:"audio/*,image/png",uploadprogress:function(){}})}.should.not.throw(Error)})}),describe(".filesize()",function(){return it("should convert to KiloBytes, etc.. not KibiBytes",function(){return t.filesize(2097152).should.eql("<strong>2.1</strong> MB"),t.filesize(2e6).should.eql("<strong>2</strong> MB"),t.filesize(2147483648).should.eql("<strong>2.1</strong> GB"),t.filesize(2e9).should.eql("<strong>2</strong> GB")})}),describe("._updateMaxFilesReachedClass()",function(){return it("should properly add the dz-max-files-reached class",function(){return t.getAcceptedFiles=function(){return{length:10}},t.options.maxFiles=10,t.element.classList.contains("dz-max-files-reached").should.not.be.ok,t._updateMaxFilesReachedClass(),t.element.classList.contains("dz-max-files-reached").should.be.ok}),it("should properly remove the dz-max-files-reached class",function(){return t.getAcceptedFiles=function(){return{length:10}},t.options.maxFiles=10,t.element.classList.contains("dz-max-files-reached").should.not.be.ok,t._updateMaxFilesReachedClass(),t.element.classList.contains("dz-max-files-reached").should.be.ok,t.getAcceptedFiles=function(){return{length:9}},t._updateMaxFilesReachedClass(),t.element.classList.contains("dz-max-files-reached").should.not.be.ok})}),describe("events",function(){return describe("progress updates",function(){return it("should properly emit a totaluploadprogress event",function(e){var n,o;return t.files=[{size:1990,accepted:!0,upload:{progress:20,total:2e3,bytesSent:400}},{size:1990,accepted:!0,upload:{progress:10,total:2e3,bytesSent:200}}],o=0,t.on("totaluploadprogress",function(t){if(t.should.equal(n),3==++o)return e()}),n=15,t.emit("uploadprogress",{}),n=97.5,t.files[0].upload.bytesSent=2e3,t.files[1].upload.bytesSent=1900,t.emit("uploadprogress",{}),n=100,t.files[0].upload.bytesSent=2e3,t.files[1].upload.bytesSent=2e3,t.emit("uploadprogress",{})})})})}),describe("helper function",function(){var e,t;return t=null,e=null,beforeEach(function(){return t=Dropzone.createElement("<div></div>"),e=new Dropzone(t,{url:"url"})}),describe("getExistingFallback()",function(){return it("should return undefined if no fallback",function(){return expect(e.getExistingFallback()).to.equal(void 0)}),it("should only return the fallback element if it contains exactly fallback",function(){return t.appendChild(Dropzone.createElement('<form class="fallbacks"></form>')),t.appendChild(Dropzone.createElement('<form class="sfallback"></form>')),expect(e.getExistingFallback()).to.equal(void 0)}),it("should return divs as fallback",function(){var n;return n=Dropzone.createElement('<form class=" abc fallback test "></form>'),t.appendChild(n),n.should.equal(e.getExistingFallback())}),it("should return forms as fallback",function(){var n;return n=Dropzone.createElement('<div class=" abc fallback test "></div>'),t.appendChild(n),n.should.equal(e.getExistingFallback())})}),describe("getFallbackForm()",function(){return it("should use the paramName without [] if uploadMultiple is false",function(){var t;return e.options.uploadMultiple=!1,e.options.paramName="myFile",t=e.getFallbackForm(),t.querySelector("input[type=file]").name.should.equal("myFile")}),it("should properly add [] to the file name if uploadMultiple is true",function(){var t;return e.options.uploadMultiple=!0,e.options.paramName="myFile",t=e.getFallbackForm(),t.querySelector("input[type=file]").name.should.equal("myFile[]")})}),describe("getAcceptedFiles() / getRejectedFiles()",function(){var t,n,o,l;return t=n=o=l=null,beforeEach(function(){return t={name:"test file name",size:123456,type:"text/html"},n={name:"test file name",size:123456,type:"text/html"},o={name:"test file name",size:123456,type:"text/html"},l={name:"test file name",size:123456,type:"text/html"},e.options.accept=function(e,n){return e===t||e===o?n():n("error")},e.addFile(t),e.addFile(n),e.addFile(o),e.addFile(l)}),it("getAcceptedFiles() should only return accepted files",function(){return e.getAcceptedFiles().should.eql([t,o])}),it("getRejectedFiles() should only return rejected files",function(){return e.getRejectedFiles().should.eql([n,l])})}),describe("getQueuedFiles()",function(){return it("should return all files with the status Dropzone.QUEUED",function(){var t,n,o,l;return t={name:"test file name",size:123456,type:"text/html"},n={name:"test file name",size:123456,type:"text/html"},o={name:"test file name",size:123456,type:"text/html"},l={name:"test file name",size:123456,type:"text/html"},e.options.accept=function(e,t){return e.done=t},e.addFile(t),e.addFile(n),e.addFile(o),e.addFile(l),e.getQueuedFiles().should.eql([]),t.done(),o.done(),e.getQueuedFiles().should.eql([t,o]),t.status.should.equal(Dropzone.QUEUED),o.status.should.equal(Dropzone.QUEUED),n.status.should.equal(Dropzone.ADDED),l.status.should.equal(Dropzone.ADDED)})}),describe("getUploadingFiles()",function(){return it("should return all files with the status Dropzone.UPLOADING",function(t){var n,o,l,r;return n={name:"test file name",size:123456,type:"text/html"},o={name:"test file name",size:123456,type:"text/html"},l={name:"test file name",size:123456,type:"text/html"},r={name:"test file name",size:123456,type:"text/html"},e.options.accept=function(e,t){return e.done=t},e.uploadFile=function(){},e.addFile(n),e.addFile(o),e.addFile(l),e.addFile(r),e.getUploadingFiles().should.eql([]),n.done(),l.done(),setTimeout(function(){return e.getUploadingFiles().should.eql([n,l]),n.status.should.equal(Dropzone.UPLOADING),l.status.should.equal(Dropzone.UPLOADING),o.status.should.equal(Dropzone.ADDED),r.status.should.equal(Dropzone.ADDED),t()},10)})})}),describe("file handling",function(){var t,n;return n=null,t=null,beforeEach(function(){var e;return n={name:"test file name",size:123456,type:"text/html"},e=Dropzone.createElement("<div></div>"),t=new Dropzone(e,{url:"/the/url"})}),afterEach(function(){return t.destroy()}),describe("addFile()",function(){return it("should properly set the status of the file",function(){var e;return e=null,t.accept=function(t,n){return e=n},t.processFile=function(){},t.uploadFile=function(){},t.addFile(n),n.status.should.eql(Dropzone.ADDED),e(),n.status.should.eql(Dropzone.QUEUED),n={name:"test file name",size:123456,type:"text/html"},t.addFile(n),n.status.should.eql(Dropzone.ADDED),e("error"),n.status.should.eql(Dropzone.ERROR)}),it("should properly set the status of the file if autoProcessQueue is false and not call processQueue",function(e){var o;return o=null,t.options.autoProcessQueue=!1,t.accept=function(e,t){return o=t},t.processFile=function(){},t.uploadFile=function(){},t.addFile(n),sinon.stub(t,"processQueue"),n.status.should.eql(Dropzone.ADDED),o(),n.status.should.eql(Dropzone.QUEUED),t.processQueue.callCount.should.equal(0),setTimeout(function(){return t.processQueue.callCount.should.equal(0),e()},10)})}),describe("enqueueFile()",function(){return it("should be wrapped by enqueueFiles()",function(){var e,n,o;return sinon.stub(t,"enqueueFile"),e={name:"test file name",size:123456,type:"text/html"},n={name:"test file name",size:123456,type:"text/html"},o={name:"test file name",size:123456,type:"text/html"},t.enqueueFiles([e,n,o]),t.enqueueFile.callCount.should.equal(3),t.enqueueFile.args[0][0].should.equal(e),t.enqueueFile.args[1][0].should.equal(n),t.enqueueFile.args[2][0].should.equal(o)}),it("should fail if the file has already been processed",function(){return n.status=Dropzone.ERROR,expect(function(){return t.enqueueFile(n)}).to.throw("This file can't be queued because it has already been processed or was rejected."),n.status=Dropzone.COMPLETE,expect(function(){return t.enqueueFile(n)}).to.throw("This file can't be queued because it has already been processed or was rejected."),n.status=Dropzone.UPLOADING,expect(function(){return t.enqueueFile(n)}).to.throw("This file can't be queued because it has already been processed or was rejected.")}),it("should set the status to QUEUED and call processQueue asynchronously if everything's ok",function(e){return n.status=Dropzone.ADDED,sinon.stub(t,"processQueue"),t.processQueue.callCount.should.equal(0),t.enqueueFile(n),n.status.should.equal(Dropzone.QUEUED),t.processQueue.callCount.should.equal(0),setTimeout(function(){return t.processQueue.callCount.should.equal(1),e()},10)})}),describe("uploadFiles()",function(){var o;return o=null,beforeEach(function(){return o=[],e.onCreate=function(e){return o.push(e)}}),afterEach(function(){return e.restore()}),it("should be wrapped by uploadFile()",function(){return sinon.stub(t,"uploadFiles"),t.uploadFile(n),t.uploadFiles.callCount.should.equal(1),t.uploadFiles.calledWith([n]).should.be.ok}),it("should ignore the onreadystate callback if readyState != 4",function(e){return t.addFile(n),setTimeout(function(){return n.status.should.eql(Dropzone.UPLOADING),o[0].status=200,o[0].readyState=3,o[0].onload(),n.status.should.eql(Dropzone.UPLOADING),o[0].readyState=4,o[0].onload(),n.status.should.eql(Dropzone.SUCCESS),e()},10)}),it("should emit error and errormultiple when response was not OK",function(e){var l,r,i,u;return t.options.uploadMultiple=!0,i=!1,u=!1,l=!1,r=!1,t.on("error",function(){return i=!0}),t.on("errormultiple",function(){return u=!0}),t.on("complete",function(){return l=!0}),t.on("completemultiple",function(){return r=!0}),t.addFile(n),setTimeout(function(){return n.status.should.eql(Dropzone.UPLOADING),o[0].status=400,o[0].readyState=4,o[0].onload(),expect(!0===i&&i===u&&u===l&&l===r).to.be.ok,e()},10)}),it("should include hidden files in the form and unchecked checkboxes and radiobuttons should be excluded",function(e){var n,o,l;return n=Dropzone.createElement('<form action="/the/url">\n  <input type="hidden" name="test" value="hidden" />\n  <input type="checkbox" name="unchecked" value="1" />\n  <input type="checkbox" name="checked" value="value1" checked="checked" />\n  <input type="radio" value="radiovalue1" name="radio1" />\n  <input type="radio" value="radiovalue2" name="radio1" checked="checked" />\n</form>'),t=new Dropzone(n,{url:"/the/url"}),o=null,t.on("sending",function(e,t,n){return o=n,sinon.spy(n,"append")}),l={name:"test file name",size:123456,type:"text/html"},t.addFile(l),setTimeout(function(){return o.append.callCount.should.equal(4),o.append.args[0][0].should.eql("test"),o.append.args[0][1].should.eql("hidden"),o.append.args[1][0].should.eql("checked"),o.append.args[1][1].should.eql("value1"),o.append.args[2][0].should.eql("radio1"),o.append.args[2][1].should.eql("radiovalue2"),o.append.args[3][0].should.eql("file"),o.append.args[3][1].should.equal(l),e()},10)}),describe("settings()",function(){return it("should correctly set `withCredentials` on the xhr object",function(){return t.uploadFile(n),o.length.should.eql(1),o[0].withCredentials.should.eql(!1),t.options.withCredentials=!0,t.uploadFile(n),o.length.should.eql(2),o[1].withCredentials.should.eql(!0)}),it("should correctly override headers on the xhr object",function(){return t.options.headers={"Foo-Header":"foobar"},t.uploadFile(n),o[0].requestHeaders["Foo-Header"].should.eql("foobar")}),it("should properly use the paramName without [] as file upload if uploadMultiple is false",function(e){var n,o,l,r;return t.options.uploadMultiple=!1,t.options.paramName="myName",n=[],r=0,t.on("sending",function(e,t,o){return r++,n.push(o),sinon.spy(o,"append")}),o={name:"test file name",size:123456,type:"text/html"},l={name:"test file name",size:123456,type:"text/html"},t.addFile(o),t.addFile(l),setTimeout(function(){return r.should.equal(2),n.length.should.equal(2),n[0].append.callCount.should.equal(1),n[1].append.callCount.should.equal(1),n[0].append.args[0][0].should.eql("myName"),n[0].append.args[0][0].should.eql("myName"),e()},10)}),it("should properly use the paramName with [] as file upload if uploadMultiple is true",function(e){var n,o,l,r,i;return t.options.uploadMultiple=!0,t.options.paramName="myName",n=null,i=0,r=0,t.on("sending",function(e,t,n){return r++}),t.on("sendingmultiple",function(e,t,o){return i++,n=o,sinon.spy(o,"append")}),o={name:"test file name",size:123456,type:"text/html"},l={name:"test file name",size:123456,type:"text/html"},t.addFile(o),t.addFile(l),setTimeout(function(){return r.should.equal(2),i.should.equal(1),t.uploadFiles([o,l]),n.append.callCount.should.equal(2),n.append.args[0][0].should.eql("myName[]"),n.append.args[1][0].should.eql("myName[]"),e()},10)})}),describe("should properly set status of file",function(){return it("should correctly set `withCredentials` on the xhr object",function(e){return t.addFile(n),setTimeout(function(){return n.status.should.eql(Dropzone.UPLOADING),o.length.should.equal(1),o[0].status=400,o[0].readyState=4,o[0].onload(),n.status.should.eql(Dropzone.ERROR),n={name:"test file name",size:123456,type:"text/html"},t.addFile(n),setTimeout(function(){return n.status.should.eql(Dropzone.UPLOADING),o.length.should.equal(2),o[1].status=200,o[1].readyState=4,o[1].onload(),n.status.should.eql(Dropzone.SUCCESS),e()},10)},10)})})})})})}).call(this);