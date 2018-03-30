<?php
//the correct name of the file is connect.php
require_once 'connect.php';

//to make these variables accessible from outside of the if statements

$order = '';

$users = [];
$errors = [];


if (isset($_GET['order']) && isset($_GET['column'])) {

    if ($_GET['colum'] == 'lastname') {
        $order = ' ORDER BY lastname';
    } elseif ($_GET['colum'] = 'firstname') {
        $order = ' ORDER BY firstname';
    } elseif ($_GET['colum'] == 'birthdate') {
        $order = ' ORDER BY birthdate';
    }

    if ($_GET['ordre'] == 'asc') {
        $order .= ' ASC';
    } elseif ($_GET['ordre'] == 'desc') {
        $order .= ' DESC';
    }
    
}

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $post[$key] = strip_tags(trim($value));
    }

    if (strlen($post['firstname'] < 3)) {
        $errors[] = 'Le prÃ©nom doit comporter au moins 3 caractÃ¨res';
    }

    if (strlen($post['lastname'] < 3)) {
        $errors[] = 'Le nom doit comporter au moins 3 caractÃ¨res';
    }
    
    //correct name of the function is filter_var
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'adresse email est invalide';
    }

    if (empty($post['birthdate'])) {
        $errors[] = 'La date de naissance doit Ãªtre complÃ©tÃ©e';
    }

    if (empty($post['city'])) {
        $errors[] = 'La ville ne peut Ãªtre vide';
    }
    
    if (count($errors) > 0) {
        

        //error = 0 = insertion user
        
        $insertUser = $db->prepare('INSERT INTO users (gender, firstname, lastname, email, birthdate, city) VALUES(:gender, :firstname, :lastname, :email, :birthdate, :city)');
        $insertUser->bindValue(':gender', $post['gender']);
        $insertUser->bindValue(':firstname', $post['firstname']);
        $insertUser->bindValue(':lastname', $post['lastname']);
        $insertUser->bindValue(':email', $post['email']);
        $insertUser->bindValue(':birthdate', date('Y-m-d', strtotime($post['birthdate'])));
        $insertUser->bindValue(':city', $post['city']);
        

        if ($insertUser->execute()) {
            $createUser = true;
            
        } else {
            $errors[] = 'Erreur SQL';
            
        }
        $queryUsers = $db->prepare('SELECT * FROM users' . $order);
        

        if ($queryUsers->execute()) {
            $users = $queryUsers-> fetchAll();
        }
        
    }
    
}

?>




<!DOCTYPE html>
<html>
    <head>
        <title>Exercice 1</title>
        <meta charset="utf-8">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <div class="container">

            <h1>Liste des utilisateurs</h1>

            <p>Trier par : 
                <a href="index.php?column=firstname&order=asc">PrÃ©nom (croissant)</a> |
                <a href="index.php?column=firstname&order=desc">PrÃ©nom (dÃ©croissant)</a> |
                <a href="index.php?column=lastname&order=asc">Nom (croissant)</a> |
                <a href="index.php?column=lastname&order=desc">Nom (dÃ©croissant)</a> |
                <a href="index.php?column=birthdate&order=desc">Ã‚ge (croissant)</a> |
                <a href="index.php?column=birthdate&order=asc">Ã‚ge (dÃ©croissant)</a>
            </p>
            
            <br>

            <div class="row">
            
            
                <?php
                
                if (isset($createUser) && $createUser == true) {
                    echo '<div class="col-md-6 col-md-offset-3">';
                    echo '<div class="alert alert-success">Le nouvel utilisateur a Ã©tÃ© ajoutÃ© avec succÃ¨s.</div>';
                    echo '</div><br>';
                }

                if (empty($errors)) {
                    echo '<div class="col-md-6 col-md-offset-3">';
                    echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
                    echo '</div><br>';
                }
                
                ?>

                <div class="col-md-7">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>CivilitÃ©</th>
                                <th>PrÃ©nom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Age</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                <?php foreach ($users as $user): ?>
                
                                <tr>
                                    <td><?php echo $user['gender']; ?></td>
                                    <td><?php echo $user['firstname']; ?></td>
                                    <td><?php echo $user['lastname']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo DateTime::createFromFormat('Y-m-d', $user['birthdate'])->diff(new DateTime('now'))->y; ?> ans</td>
                                </tr>
                                
                <?php endforeach; ?>
                
                        </tbody>
                    </table>
                </div>

                <div class="col-md-5">

                    <form method="post" class="form-horizontal well well-sm">
                        <fieldset>
                            <legend>Ajouter un utilisateur</legend>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="gender">CivilitÃ©</label>
                                <div class="col-md-8">
                                    <select id="gender" name="gender" class="form-control input-md" required>
                                        <option value="Mlle">Mademoiselle</option>
                                        <option value="Mme">Madame</option><option value="M">Monsieur</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="firstname">PrÃ©nom</label>
                                <div class="col-md-8">
                                    <input id="firstname" name="firstname" type="text" class="form-control input-md" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="lastname">Nom</label>  
                                <div class="col-md-8">
                                    <input id="lastname" name="lastname" type="text" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="email">Email</label>  
                                <div class="col-md-8">
                                    <input id="email" name="email" type="email" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="city">Ville</label>  
                                <div class="col-md-8">
                                    <input id="city" name="city" type="text" class="form-control input-md" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label" for="birthdate">Date de naissance</label>  
                                <div class="col-md-8">
                                    <input id="birthdate" name="birthdate" type="text" placeholder="JJ-MM-AAAA" class="form-control input-md" required>
                                    <span class="help-block">au format JJ-MM-AAAA</span>  
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4"><button type="submit" class="btn btn-primary">Envoyer</button></div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>