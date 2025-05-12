<?php
    include_once('partials/header.php');
    echo'<link rel="stylesheet" href="../css/contact.css>'
?>   
        <main>
            <section class="contact">
            <h1 class="h1">Contact us</h1>
            <div class="contact">
            <form action="thankyou.php">
                <label for="name">Name and Surname:</label><br>
                <input type="text" id="name" name="name" value="name" required><br><br>



                <label for="email">email:</label><br>
                <input type="email" id="email" name="email" value="email" required><br>

                <label class="labe1" for="agreeig">consent to data processing:</label>
                
                <input type="checkbox" id="checkbox" value="checkbox" required/><br><br>

                <select name="select course" id="select course">
                    <option >Choose the course</option>
                    <option value="web" >Web development</option>
                    <option value="data">Data base</option>
                    <option value="game">game development</option>
                    <option value="software">software development</option>
                  </select><br><br>
                <input type="submit" value="Submit" ><br><br>
            </form>
            </div>
            </section>
            
            
            </form>
            </main>

<?php
  include_once('partials/footer.php')
?>  