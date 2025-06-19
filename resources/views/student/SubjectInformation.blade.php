<head>
    <title>Course and University Recommendation System: Subject Information</title>
    
    
</head>

<body>
    <div>
        <x-header title="Subject Information" />
        <div>
            <div>
                <form>
                    <label>Subject</label>
                    <select>
                        <option value=""></option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>
                    <input type="text" name="subject1marks" value="{{ old('subject1marks') }}"></input>
                </form>
            </div>
            <div>
                <button type="submit">Submit</button>
            </div>
        </div>
        <div>
            <a href="">
                <button>Next</button>
            </a>
        </div>
    </div>
    <x-footer />
</body>