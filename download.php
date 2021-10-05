namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller {

    public function handleRemoteFileDownload($url){
            $contentTypes = [
                'application/pdf' => 'pdf',
                'image/gif' => 'gif',
                'image/jpeg'=>'image/jpeg',
                'image/png'=>'png',
                'text/html'=>'html',
                'application/zip'=>'zip'
            ];

            $response = Http::get($url);
            if($response->successful()){
                /* status code is between 200 & 300 */

                /* extract the raw body */
                $content = $response->body();

                /* get the headers */
                $headers = ($response->headers());

                /* get the file type */
                $fileType = $headers['Content-Type'][0];

                /* to generate a random name for file */
                $bytes = random_bytes(20);

                /* TODO:  handle exception here if content type not in our list */


                $filename = (bin2hex($bytes)).'.'.$contentTypes[$fileType];
                $filepath_to_download =  'downloads/'.$filename;

                /* move file to the local directory */

                Storage::disk('local')->put($filepath_to_download, ($content), 'public');
            }else{
                /* handle exception here */
                /* logs message to the users */
            }

        }


}
