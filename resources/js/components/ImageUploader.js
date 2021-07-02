import React from 'react';
import ReactDOM from 'react-dom';
import Dropzone from 'react-dropzone';

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
        fetch('/images')
            .then((response) => response.json())
            .then(({data}) => component.setState({images: data.images}))
            .catch((error) => console.log(error));
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
            .finally(() => component.setState({file: []}));
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
                                return <div className="grid__item" key={index}><img src={value} alt={value}/></div>
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
