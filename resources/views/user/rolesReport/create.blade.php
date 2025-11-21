<div class="modal-header">
    <h5 class="modal-title">Manage Role Hierarchy</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <form id="roleHierarchyForm" action="{{ route('users.rolesReport.store') }}" method="POST">
        @csrf

        <!-- Select Current Role -->
        <div class="mb-3">
            <label class="form-label">Select Role</label>
            <select name="role_id" id="role_id" class="form-control" required>
                <option value="">Select Role</option>

                @foreach($roles as $role)
                    <option value="{{ $role->id }}"
                        {{ isset($currentRoleId) && $currentRoleId == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Parent Role -->
        <div class="mb-3">
            <label class="form-label">Parent Role (Reports To)</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Top Level (No Parent)</option>

                @foreach($roles as $role)
                    @if($currentRoleId != $role->id)
                        <option value="{{ $role->id }}"
                            @if(isset($existing) && $existing->parent_id == $role->id) selected @endif>
                            {{ $role->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <!-- Hierarchy Preview -->
        <div class="my-3">
            <label class="form-label"><strong>Hierarchy Preview</strong></label>

            <div id="hierarchyPreview" class="p-3 border rounded bg-light">
                <p class="text-muted">Select role & parent to preview hierarchy.</p>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Save Hierarchy</button>
        </div>

    </form>

</div>

<!-- LIVE PREVIEW SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    function updatePreview() {

        let role = document.getElementById("role_id");
        let parent = document.getElementById("parent_id");
        let preview = document.getElementById("hierarchyPreview");

        if (!role.value) {
            preview.innerHTML = `<p class="text-muted">Select role & parent to preview hierarchy.</p>`;
            return;
        }

        let roleText = role.options[role.selectedIndex].text;
        let parentText = parent.value ? parent.options[parent.selectedIndex].text : "Top Level";

        preview.innerHTML = `
            <div class="tree">
                <ul>
                    <li>
                        <span class="node">${parentText}</span>
                        <ul>
                            <li><span class="node">${roleText}</span></li>
                        </ul>
                    </li>
                </ul>
            </div>
        `;
    }

    document.getElementById("role_id").addEventListener("change", updatePreview);
    document.getElementById("parent_id").addEventListener("change", updatePreview);

    updatePreview();
});
</script>

<!-- AJAX SUBMIT -->
<script>
$(function() {

    $("#roleHierarchyForm").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);

                if (response.status === true) {
                    toastr.success(response.message);
                    $(".modal").modal('hide');

                    if ($('#roles-report-table').length) {
                        $('#roles-report-table').DataTable().ajax.reload();
                    }
                } else {
                    toastr.error(response.message || "Failed to save hierarchy");
                }
            },

            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || "Something went wrong!");
            }
        });
    });

});
</script>

<!-- TREE CSS -->
<style>
.tree ul {
    padding-left: 20px;
    position: relative;
}

.tree ul::before {
    content: "";
    border-left: 2px solid #777;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 8px;
}

.tree li {
    list-style: none;
    position: relative;
    padding: 8px 0 8px 20px;
}

.tree li::before {
    content: "";
    border-top: 2px solid #777;
    position: absolute;
    top: 18px;
    left: 0;
    width: 20px;
}

.node {
    display: inline-block;
    padding: 6px 12px;
    background: #fff;
    border: 1px solid #bbb;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 500;
}
</style>
