import React from 'react';
import ReactDOM from 'react-dom';

class ImageUploader extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            file: '',
            images: []
        };
    }

    handleChange = (event) => {
        this.setState({file: event.target.files[0]});
    }

    handleSubmit = (event) => {
        event.preventDefault();

        let formData = new FormData();
        formData.append('images[]', this.state.file);

        let vm = this;
        fetch('/api/images', {
            method: 'POST',
            body: formData
        }).then(function (response) {
            return response.json();
        }).then(function ({data}) {
            vm.updateImages(data.images);
        }).catch(function (error) {
            console.log(error);
        });
    }

    updateImages(images) {
        this.setState({'images': images.concat(this.state.images)});
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center mb-5">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-body">
                                <form onSubmit={this.handleSubmit}>
                                    <div className="form-row align-items-center">
                                        <div className="col-auto flex-grow-1">
                                            <input type="file" name="file" onChange={this.handleChange} />
                                        </div>
                                        <div className="col-auto">
                                            <button disabled={!this.state.file} className="btn btn-success">Upload Image</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className="card">
                            <div className="card-body text-center">
                                DropZone
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
