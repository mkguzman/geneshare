<?php include 'includes/header.inc.php'; ?>

    <title>Alchemy: About</title>

<?php include 'includes/body.inc.php'; ?>

<?php include 'includes/menu.inc.php'; ?>

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>About Alchemy</h1>
        </div>
        <p class="lead">Alchemy is an open-source, real-time QA/QC analytics platform for the clinical laboratories of the University of Alabama at Birmingham.</p>
        <p>The Alchemy project is designed, built, and maintained under the direction of <a href="https://services.medicine.uab.edu/facultyDirectory/FacultyData.asp?s_lname=Park&s_keyword=&s_fname=Seung&FacultyTypeID=&s_Department_Name=&s_ResearchTitle=&FID=61255">Seung Park, MD</a> of the <a href="http://www.uab.edu/medicine/pathology/">University of Alabama at Birmingham, Department of Pathology, Division of Informatics</a>.  It is written (a) as a way to teach software development principles and lifecycle management to residents and fellows, and (b) for maximum usability by laboratory staff.  Alchemy is architected utilizing a standard LEMP stack-based infrastructure, consisting of the following:</p>
        <ul>
          <li><a href="http://ubuntu.com/">Ubuntu Linux Server</a></li>
          <li><a href="http://wiki.nginx.org/">nginx</a></li>
          <li><a href="https://mariadb.org/">MariaDB</a></li>
          <li><a href="http://php-fpm.org/">PHP-FPM</a></li>
          <li><a href="http://getbootstrap.com/">Twitter Bootstrap</a></li>
        </ul>
        <h2>Supported Tests</h2>
        <table class="table table-striped">
          <tr>
            <th>Test</th>
            <th>Laboratory Section</th>
            <th>Version Added</th>
          </tr>
          <tr>
            <td>Antibiotic Susceptibilities (Antibiograms)</td>
            <td>Microbiology</td>
            <td>0.3</td>
          </tr>
          <tr>
            <td>HCV Quantification (HCVQNTX)</td>
            <td>Molecular Diagnostics</td>
            <td>0.2</td>
          </tr>
          <tr>
            <td>HCV Quantification, CDC (HCVQNTX-CDC)</td>
            <td>Molecular Diagnostics</td>
            <td>0.4</td>
          </tr>
          <tr>
            <td>HIV1 Quantification (HIV1QNTX)</td>
            <td>Molecular Diagnostics</td>
            <td>0.1</td>
          </tr>
          <tr>
            <td>HIV1 Quantification, CDC (HIV1QNTX-CDC)</td>
            <td>Molecular Diagnostics</td>
            <td>0.4</td>
          </tr>
        </table>
        <p>Other sections of the clinical laboratory are encouraged to collaborate with us in order to automate reporting in a similar fashion.  If you are interested in doing so, please <a href="contact.php">contact</a> us directly.</p>
        <h2>Changelog</h2>
        <table class="table table-striped">
          <tr>
            <th>Version</th>
            <th>Date</th>
            <th>Comments</th>
          </tr>
          <tr>
            <td>0.4 <em>"Diana's Tree"</em></td>
            <td>10 July 2014</td>
            <td>
              <ul>
                <li>CDC HCVQNTX QA real-time reporting</li>
                <li>CDC HIV1QNTX QA real-time reporting</li>
                <li>Limit Molecular Diagnostics QA numbers to 2 significant figures</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td>0.3 <em>"Chalcanthum"</em></td>
            <td>14 March 2014</td>
            <td>
              <ul>
                <li>Antibiotic susceptibilities real-time reporting</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td>0.2 <em>"Bezoardicum Joviale"</em></td>
            <td>15 October 2013</td>
            <td>
              <ul>
                <li>HCVQNTX QA real-time reporting</li>
                <li>Code cleanup and refactoring</li>
              </ul>
            </td>
          </tr>
          <tr>
            <td>0.1 <em>"Alkahest"</em></td>
            <td>9 October 2013</td>
            <td>
              <ul>
                <li>Initial release</li>
                <li>CSV upload from Cerner</li>
                <li>HIV1QNTX QA real-time reporting</li>
              </ul>
            </td>
          </tr>
        </table>
      </div>
    </div>

<?php include 'includes/footer.inc.php'; ?>
