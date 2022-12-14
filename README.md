# lrms



## Getting started

To make it easy for you to get started with GitLab, here's a list of recommended next steps.

Already a pro? Just edit this README.md and make it your own. Want to make it easy? [Use the template at the bottom](#editing-this-readme)!

## Add your files

- [ ] [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
- [ ] [Add files using the command line](https://docs.gitlab.com/ee/gitlab-basics/add-file.html#add-a-file-using-the-command-line) or push an existing Git repository with the following command:

```
cd existing_repo
git remote add origin https://gitlab.com/softbdltd/lrms.git
git branch -M main
git push -uf origin main
```

## Integrate with your tools

- [ ] [Set up project integrations](https://gitlab.com/softbdltd/lrms/-/settings/integrations)

## Collaborate with your team

- [ ] [Invite team members and collaborators](https://docs.gitlab.com/ee/user/project/members/)
- [ ] [Create a new merge request](https://docs.gitlab.com/ee/user/project/merge_requests/creating_merge_requests.html)
- [ ] [Automatically close issues from merge requests](https://docs.gitlab.com/ee/user/project/issues/managing_issues.html#closing-issues-automatically)
- [ ] [Enable merge request approvals](https://docs.gitlab.com/ee/user/project/merge_requests/approvals/)
- [ ] [Automatically merge when pipeline succeeds](https://docs.gitlab.com/ee/user/project/merge_requests/merge_when_pipeline_succeeds.html)

## Test and Deploy

Use the built-in continuous integration in GitLab.

- [ ] [Get started with GitLab CI/CD](https://docs.gitlab.com/ee/ci/quick_start/index.html)
- [ ] [Analyze your code for known vulnerabilities with Static Application Security Testing(SAST)](https://docs.gitlab.com/ee/user/application_security/sast/)
- [ ] [Deploy to Kubernetes, Amazon EC2, or Amazon ECS using Auto Deploy](https://docs.gitlab.com/ee/topics/autodevops/requirements.html)
- [ ] [Use pull-based deployments for improved Kubernetes management](https://docs.gitlab.com/ee/user/clusters/agent/)
- [ ] [Set up protected environments](https://docs.gitlab.com/ee/ci/environments/protected_environments.html)

***

## Setup Project

- clone project from gitlab.
- run ```composer install```
- run ```php artisan migrate:fresh --seed```
- run ```php artisan db:seed --class=TablePermissionKeySeeder```

### Menu Builder

You can import/export menu using menu builder. goto /menu-builder/menus, then for the first time press import menu
button. it will help you to import menu from menu-backup folder. If you create any menu, you could push it to git using
export.

### Basic Instruction

- All model should extend BaseModel class.
- All controller should extend BaseController class.

### Javascript Guideline

- use ```serverSideDatatableFactory()``` function for datatable.js rendering.

#### Date time helper. (Date time output format is always - ```Y-m-d H:i```)

- use .flat-date class to enable date input. **(input type should be text.)
- use .flat-time class to enable time input. **(input type should be text.)
- use .flat-datetime class to enable time input. **(input type should be text.)

### CSS/JS compilation

- There are no benefit to edit public/css or public/js file. If you need any customization, you have to edit it from
  resources/js or resources/sass, and then compile

### Policy & Permission

```php
$this->authorize('viewUserPermission', $user);
public function viewUserPermission(User $user, User $model)
{
    return $user->hasPermission('view_user_permission');
}
```

### File Handle

```php
App\Helpers\Classes\FileHandler::storePhoto(?UploadedFile $file, ?string $dir = '', ?string $fileName = ''): ?string
App\Helpers\Classes\FileHandler::deleteFile(?string $path): bool


// image storing example:
$filename = FileHandler::storePhoto($file, 'dirname', 'custom-file-name');
$user = new User();
$user->pic = 'dirname/'. $filename;
$user->save();
```

```html
<!--image show/retrieving example-->
<img src="{{asset('storage/'. $user->pic)}}"/>
```

### Select2 API html format

Just add class ```select2-ajax-wizard``` to enable select2 on your select element

```html
<select class="form-control select2-ajax-wizard"
        name="user_id2"
        id="user_id2"
        data-model="{{base64_encode(Softbd\Acl\Models\User::class)}}"
        data-label-fields="{name_en} - {institute.title_en}"
        data-depend-on="user_type_id:#user_type_id"
        data-depend-on-optional="user_type_id:#user_type_id"
        data-dependent-fields="#name_en"
        data-filters="{{json_encode(['name_en' => 'Baker Hasan'])}}"
        data-preselected-option="{{json_encode(['text' => 'Baker Hasan', 'id' => 1])}}"
        data-placeholder="Select option"
>
    <option selected disabled>Select User</option>
</select>
```

***

##### Model ```data-model```

This will define which model you want to fetch.

Model namespace should encode using base64_encode. Otherwise, it won't work.

excepted format
```data-model="{{base64_encode(Softbd\Acl\Models\User::class)}}"```


***

##### Label Fields ```data-label-fields```

The definition of which field you want to fetch from model and display in select2.

```data-label-fields="{name_en}"```

if its relational column

```data-label-fields="{institute.title_en}"```

If you want to show multiple column.

```data-label-fields="{name_en} - {institute.title_en}"```

***

##### Depend on fields ```data-depend-on```

When the resource depends on some other input field, then

```data-depend-on="user_type_id"```

Here, user_type_id field value passed to ajax request for filter.

You may define column name and field name as well, Otherwise it will parse automatically

ID
```data-depend-on="user_type_id:#user_type_id"```

Class
```data-depend-on="user_type_id:.user_type_id"```

Name
```data-depend-on="user_type_id:[name=user_type_id]"```

***

##### Depend on optional ```data-depend-on-optional```

Where depend on always pass the value to ajax, but ```data-depend-on-optional``` only pass the value if the value isn't
empty.

```data-depend-on-optional="user_type_id:#user_type_id"```

selector criteria same as ```data-depend-on```.

***

##### Dependant field ```data-dependent-fields```

If any of the field dependent to this field, then.

```data-dependent-fields="#name_en"```

multiple
```data-dependent-fields="#name_en|.name_bn|[name=email]"```

***

##### Filters ```data-filters```

Additional filter.
```data-filters="{{json_encode(['name_en' => 'Hasan'])}}"```


***

##### Scopes ```data-scopes```

Apply scopes.
```data-scopes="acl|bcl"```

***

##### Preselected option ```data-preselected-option```

```data-preselected-option="{{json_encode(['text' => 'Baker Hasan', 'id' => 1])}}"```

***

##### Placeholder ```data-placeholder```

```data-data-placeholder="Select User"```

### Fetch model using AJAX

```javascript
$.ajax({
    type: 'post',
    url: '{{route('web-api.model-resources')}}',
    data: {
        resource: {
            model: "{{base64_encode(\Softbd\Acl\Models\User::class)}}",
            columns: 'name_en|institute.title_en|institute.title_bn',
            scopes: 'acl',
        }
    }
}).then(function (res) {
    console.log(res);
});
```
