<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <button type="button" class="tag-btn" onclick="addTag('Fantasy')">Fantasy</button>
    <button type="button" class="tag-btn" onclick="addTag('Adventure')">Adventure</button>
    <button type="button" class="tag-btn" onclick="addTag('Action')">Action</button>
    <button type="button" class="tag-btn" onclick="addTag('Romance')">Romance</button>
    <button type="button" class="tag-btn" onclick="addTag('Sci-Fi')">Sci-Fi</button>
    <button type="button" class="tag-btn" onclick="addTag('Horror')">Horror</button>
    <button type="button" class="tag-btn" onclick="addTag('Magic')">Magic</button>
    <button type="button" class="tag-btn" onclick="addTag('Thriller')">Thriller</button>
    <button type="button" class="tag-btn" onclick="addTag('Gore')">Gore</button>
    <button type="button" class="tag-btn" onclick="addTag('Ancient')">Ancient</button>
    <script>
        function addTag(tag) {
            var input = document.getElementById('tags');
            var selectedTagsContainer = document.getElementById('selected-tags');
            // Convert all tags to lowercase for case-insensitive comparison and remove empty entries
            var currentTags = input.value.split(',').map(function(tag) { return tag.trim().toLowerCase(); }).filter(tag => tag !== "");

            if (!currentTags.includes(tag.toLowerCase())) {
                currentTags.push(tag.toLowerCase()); // Add the tag in lowercase
                input.value = currentTags.join(', '); // Ensure no leading commas or spaces

                // Update the display of selected tags
                var tagSpan = document.createElement('span');
                tagSpan.textContent = tag + " "; // Display the original case
                var removeBtn = document.createElement('button');
                removeBtn.textContent = 'x';
                removeBtn.onclick = function() { removeTag(tag); };
                tagSpan.appendChild(removeBtn);
                selectedTagsContainer.appendChild(tagSpan);
            } else {
                // Optionally alert the user that the tag is already added
                alert("Tag '" + tag + "' is already added.");
            }
        }

        function removeTag(tagToRemove) {
            var input = document.getElementById('tags');
            var selectedTagsContainer = document.getElementById('selected-tags');
            // Ensure tags are trimmed, lowercased, and non-empty
            var currentTags = input.value.split(',').map(tag => tag.trim().toLowerCase()).filter(tag => tag !== "" && tag !== tagToRemove.toLowerCase());

            // Join the tags with a comma and a space, and update the input value
            input.value = currentTags.join(', ');

            // Clear and rebuild the display of selected tags
            selectedTagsContainer.innerHTML = '';
            currentTags.forEach(tag => {
                var tagSpan = document.createElement('span');
                tagSpan.textContent = tag + " "; // Display the original case
                var removeBtn = document.createElement('button');
                removeBtn.textContent = 'x';
                removeBtn.onclick = function() { removeTag(tag); };
                tagSpan.appendChild(removeBtn);
                selectedTagsContainer.appendChild(tagSpan);
            });
        }
        function registerNewTag() {
            var input = document.getElementById('new-tag');
            var newTag = input.value.trim();

            if (newTag) {
                // Simulate sending the new tag to a server or adding to a database
                console.log("Registering new tag:", newTag); // Replace this with actual API call or database insertion logic

                // Update the tag options to include the new tag
                var tagOptionsContainer = document.getElementById('tag-options');
                var newTagButton = document.createElement('button');
                newTagButton.type = 'button';
                newTagButton.className = 'tag-btn';
                newTagButton.textContent = newTag;
                newTagButton.onclick = function() { addTag(newTag); };

                tagOptionsContainer.appendChild(newTagButton);

                document.getElementById('tag-registration-status').innerHTML = `<p class='text-success'>Tag '${newTag}' registered successfully.</p>`;
                input.value = ''; // Clear the input after successful registration
            } else {
                document.getElementById('tag-registration-status').innerHTML = `<p class='text-danger'>Please enter a tag to register.</p>`;
            }
        }
    </script>
</body>
</html>