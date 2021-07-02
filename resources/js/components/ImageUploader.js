import React from 'react';
import ReactDOM from 'react-dom';
import Dropzone from 'react-dropzone';
import NProgress from 'nprogress';

class ImageUploader extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            file: [],
            images: []
        };
    }

    componentDidMount() {
        let component = this;
        NProgress.start();
        fetch('/images')
            .then((response) => response.json())
            .then(({data}) => component.setState({images: data.images}))
            .catch((error) => console.log(error))
            .finally(() => NProgress.done());
    }

    handleChange = (event) => {
        this.setState({file: [event.target.files[0]]});
    }

    handleSubmit = (event) => {
        event.preventDefault();
        this.postImages();
    }

    handleDropzone = (images) => {
        this.setState({file: images});
        this.postImages();
    }

    postImages() {
        NProgress.start();
        let formData = new FormData();
        this.state.file.forEach((file) => {
            formData.append('images[]', file);
        });

        let component = this;
        fetch('/images', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name=csrf-token]").content
            },
            body: formData,
        }).then((response) => response.json())
            .then(({data}) => component.setState({images: data.images.concat(component.state.images)}))
            .catch((error) => console.log(error))
            .finally(() => {
                component.setState({file: []})
                NProgress.done();
            });
    }

    removeImage(index) {
        NProgress.start();
        let component = this;
        fetch(`/images/${index}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector("[name=csrf-token]").content
            }
        }).then((response) => {
                let images = component.state.images;
                images.splice(index, 1);
                component.setState({images: images});
            })
            .catch((error) => console.log(error))
            .finally(() => NProgress.done());
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center mb-5">
                    <div className="col-md-8">
                        <div className="card h-100">
                            <div className="card-body d-flex align-items-center">
                                <form onSubmit={this.handleSubmit} className="w-100">
                                    <div className="form-row align-items-center">
                                        <div className="col-auto flex-grow-1">
                                            <input type="file" name="file" onChange={this.handleChange} />
                                        </div>
                                        <div className="col-auto">
                                            <button disabled={!this.state.file.length} className="btn btn-success">Upload Image</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className="card">
                            <div className="card-body text-center">
                                <Dropzone onDrop={acceptedFiles => this.handleDropzone(acceptedFiles)}>
                                    {({getRootProps, getInputProps}) => (
                                        <section>
                                            <div {...getRootProps()}>
                                                <input {...getInputProps()} />
                                                <p>Drag 'n' drop some files here, or click to select files</p>
                                            </div>
                                        </section>
                                    )}
                                </Dropzone>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col">
                        <div className="grid">
                            {this.state.images.map((value, index) => {
                                return <div className="grid__item" key={index}><img src={value} alt={value}/><button className="btn btn-danger" onClick={() => this.removeImage(index)}>Remove</button></div>
                            })}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default ImageUploader;

if (document.getElementById('image-uploader')) {
    ReactDOM.render(<ImageUploader />, document.getElementById('image-uploader'));
}
