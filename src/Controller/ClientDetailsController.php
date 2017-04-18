<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ClientDetails Controller
 *
 * @property \App\Model\Table\ClientDetailsTable $ClientDetails
 */
class ClientDetailsController extends AppController
{
    //file upload function
    public function upload($clientId,$uniVal,$data)
    {
//        $userId = $this->request->session()->read('Auth.User.id');
        define("UPLOAD_DIR", ROOT.DS.APP_DIR.DS."webroot/img/".$uniVal."/");
        $photoName = $signatureName = null;

        //for client photo
        if(!empty($data['client_photo']))
        {
                //// debug("hello"); die();
                $myFile = $data['client_photo'];

                if ($myFile["error"] !== UPLOAD_ERR_OK) {
                    echo "<p>An error occurred.</p>";
                    exit;
                }

                // ensure a safe filename
                $photoName = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

                $i = 0;
                $parts = pathinfo($photoName);
                if(!file_exists(UPLOAD_DIR . $photoName))
                {
                    mkdir("./img/".$uniVal,0777,true);
                }

                // don't overwrite an existing file
//                while (file_exists(UPLOAD_DIR . $photoName)) {
//                    $i++;
//                    $photoName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
//                }

                // preserve file from temporary directory
                $success = move_uploaded_file($myFile["tmp_name"],"./img/".$uniVal."/". $photoName);
                if (!$success) {
                    echo "47 <p>Unable to save file.</p>";
                    exit;
                }

                // set proper permissions on the new file
                chmod("./img/".$uniVal."/". $photoName, 0777);
        }

        //for client's signature photo
        if(!empty($data['client_sign_photo']))
        {
            $myFile = $data['client_sign_photo'];

                if ($myFile["error"] !== UPLOAD_ERR_OK) {
                    echo "<p>An error occurred.</p>";
                    exit;
                }

                // ensure a safe filename
                $signatureName = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

                $i = 0;
                $parts = pathinfo($signatureName);
                if(!file_exists(UPLOAD_DIR . $signatureName))
                {
                    mkdir("./img/".$uniVal,0777,true);
                }
                // don't overwrite an existing file

//                while (file_exists(UPLOAD_DIR . $signatureName)) {
//                    $i++;
//                    $signatureName = $parts["filename"] . "-" . $i . "." . $parts["extension"];
//                }

                // preserve file from temporary directory
                $success = move_uploaded_file($myFile["tmp_name"], "./img/".$uniVal."/". $signatureName);
                if (!$success) {
                    echo "82 <p>Unable to save file.</p>";
                    exit;
                }

                // set proper permissions on the new file
                chmod("./img/".$uniVal."/". $signatureName, 0777);
        }

        if($this->request->is('post'))
        {
            try
            {
                $this->ClientDetails->updateAll(
                    [
                        'client_photo' => "/img/".$uniVal."/".$photoName,
                        'client_sign_photo' => "/img/".$uniVal."/".$signatureName
                    ],
                    [
                        'id' => $clientId
                    ]
                );
                $this->redirect("/addRd/".$clientId);
            }
            catch (\Exception $e)
            {
                $this->Flash->error($e->getMessage());
                $this->redirect("/addClients");
            }
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
//        debug($_POST);
//        debug($_FILES);
        //$this->upload($_FILES);
//        die();
        $clientDetail = $this->ClientDetails->newEntity();
        if ($this->request->is('post')) {
            $clientDetail = $this->ClientDetails->patchEntity($clientDetail, $this->request->data);

            try{
                $saveData = $this->ClientDetails->save($clientDetail);
                if ($saveData) {
                    $uniqueUserData = str_replace(" ","_",$_POST['client_name'].$saveData->id);
                    $clientId = $saveData->id;
                    $this->upload($clientId,$uniqueUserData,$_FILES);
                    $this->Flash->success(__('The client\'s personal detail has been saved.'));
                }
            }
            catch(\Exception $e)
            {
                $this->Flash->error($e->getMessage());
                $this->Flash->error(__('The client\'s personal detail could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('clientDetail'));
        $this->set('_serialize', ['clientDetail']);
    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $clientDetails = $this->paginate($this->ClientDetails);

        $this->set(compact('clientDetails'));
        $this->set('_serialize', ['clientDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Client Detail id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientDetail = $this->ClientDetails->get($id, [
            'contain' => []
        ]);

        $clientRdModel = $this->loadModel('ClientRd');
        $clientRdData = $clientRdModel->find('all',[
            'conditions' => ['client_id' => $id]
        ]);

        $this->set('clientDetail', $clientDetail);
        $this->set('_serialize', ['clientDetail']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Detail id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientDetail = $this->ClientDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientDetail = $this->ClientDetails->patchEntity($clientDetail, $this->request->data);
            if ($this->ClientDetails->save($clientDetail)) {
                $this->Flash->success(__('The client detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client detail could not be saved. Please, try again.'));
        }
        $this->set(compact('clientDetail'));
        $this->set('_serialize', ['clientDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Detail id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientDetail = $this->ClientDetails->get($id);
        if ($this->ClientDetails->delete($clientDetail)) {
            $this->Flash->success(__('The client detail has been deleted.'));
        } else {
            $this->Flash->error(__('The client detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
