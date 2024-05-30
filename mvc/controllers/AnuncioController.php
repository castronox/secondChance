<?php
class anuncioController extends Controller
{

    #---------------------------------------------------------------------#
    #----------------->        Listar anuncios          <-----------------#
    #---------------------------------------------------------------------#
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                       



    public function list(int $page = 1)
    {

        $filtro = Filter::apply('anuncios');
        $limit = RESULTS_PER_PAGE;

        #SI NO HAY FILTRO
        if ($filtro) {
            $total = Anuncio::filteredResults($filtro);

            $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);

            # Recupera la lista de anuncios con el filtro aplicado
            $anuncios = Anuncio::filter($filtro, $limit, $paginator->getOffset());

        } else {
            
            $total = Anuncio::total();

            $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);

            $anuncios = Anuncio::orderBy('nombre', 'DESC', $limit, $paginator->getOffset());
        # dd($anuncios);
        }

        # Carga la vista

        $this->loadView('anuncio/list', [
            'anuncios' => $anuncios,
            'paginator' => $paginator,
            'filtro' => $filtro
        ]);
    }

    #---------------------------------------------------------------------#
    #----------------->          CREAR ANUNCIO          <-----------------#
    #---------------------------------------------------------------------#
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    #       
    public function create(){
        Auth::oneRole(['ROLE_ADMIN','ROLE_VENDOR']);
        
        view('anuncio/create',[
            'user' => Login::user()
        ]);

    }




    public function store(int $id=0)
    {


        # Implementa gestión de autorización.
        Auth::oneRole(['ROLE_ADMIN', 'ROLE_VENDOR']);

        # Comprobamos que la peticion venga del formulario --------------------
        if (!$this->request->has('guardar'))
            throw new FormException('No se recibió el formulario');


        $anuncio = new Anuncio(); # Creamos un objeto anuncio en el que
        # introduciremos los datos del formulario


        $anuncio->iduser = $this->request->post('idusuario');
        $anuncio->nombre = $this->request->post('nombre');
        $anuncio->descripcion = $this->request->post('descripcion');
        $anuncio->anyo = $this->request->post('anyo');
        $anuncio->precio = $this->request->post('precio');
        $anuncio->estado = $this->request->post('estado');


        try {

            #dd($anuncio);
            $anuncio->saneate();
            $anuncio->save();


            if (UploadedFile::check('foto')) {
                # Crea el nuevo UplodadedFile
                $file = new UploadedFile(
                    'foto',		# Nombre del input
                    800000,         # Asigna un tamaño máximo al archivo
                    ['image/png', 'image/jpeg', 'image/gif']
                );

                # Guarda el fichero
                $anuncio->foto = $file->store('../public/' . ANUNCIO_IMAGE_FOLDER, 'product__');
            }

            $anuncio->update();

            Session::success("Guardado del anuncio $anuncio->nombre correcto.");
            redirect("/anuncio/show/$anuncio->id");

            # Flashea un mensaje que VERIFICA LA CORRECTA subida del anuncio por sesión (para que no se borre al redireccionar)

            Session::success("Guardado del anuncio $anuncio->nombre correcto.");

            # Una vez cumplida la condición, redirecciona a los detalles del anuncio que hemos creado
            redirect("/anuncio/show/$anuncio->id");
        } catch (SQLException $e) { # Si la condición de save(); no se cumple, Indicamos un error

            # Flashea el mensaje de error por sesión
            Session::error("No se pudo guardar el anuncio $anuncio->nombre.");

            # --------------------------------------------------------------

            # Si estamos en modo DEBUG, iremos a la página de ERROR.
            if (DEBUG)
                throw new Exception($e->getMessage());

            # Si no, volveremos al formulario de creación del anuncio.

            redirect("/anuncio/create");
        } catch (UploadException $e) {

            Session::warning("El anuncio se guardo correctamente, pero no se subió la imagen de foto.");

            if (DEBUG)
                throw new Exception($e->getMessage());

            redirect("/anuncio/edit/$anuncio->id");
        }


    }



    public function edit(int $id = 0)
	{
		# Implementa el acceso al rol de administrador o de vendedor
		Auth::oneRole(['ROLE_VENDOR']);

		$anuncio = Anuncio::findOrFail($id, "No se encontró el anuncio.");


		# Carga la vista con el formulario de edición			
		view('anuncio/edit', [
			'anuncio' => $anuncio,
            
		]);
	}

	# Funcion para actualizar el anuncio
	public function update()
	{
		# Implementa el acceso al rol de administrador o de vendedor
		Auth::oneRole(['ROLE_ADMIN', 'ROLE_VENDOR']);

		if (!$this->request->has('actualizar'))
			throw new FormException('No se recibieron datos');

		$id = intval($this->request->post('id')); # Recuperar el id via POST

		$anuncio = Anuncio::findOrFail($id, "No se ha encontrado el anuncio deseado.");


		# Recuperar el resto de campos
        $anuncio->iduser = $this->request->post('idusuario');
        $anuncio->nombre = $this->request->post('nombre');
        $anuncio->descripcion = $this->request->post('descripcion');
        $anuncio->anyo = $this->request->post('anyo');
        $anuncio->precio = $this->request->post('precio');
        $anuncio->estado = $this->request->post('estado');

		# Intenta actualizar el anuncio

		try {
			# --------> ACTUALIZA LA foto DEL anuncio  <--------
			if (UploadedFile::check('foto')) {

				$file = new UploadedFile(
					'foto',		# Nombre del input
					800000,         # Asigna un tamaño máximo al archivo
					['image/png', 'image/jpeg', 'image/gif']
				);

				if ($anuncio->foto)

					File::remove('../public/' . ANUNCIO_IMAGE_FOLDER . '/' . $anuncio->foto);	# Elimina el fichero anterior, si existe.
				$anuncio->foto = $file->store('../public' . ANUNCIO_IMAGE_FOLDER, 'product__');
			}



			$anuncio->update();
			Session::success("Actualización del anuncio $anuncio->nombre correcta.");
			redirect("/Anuncio/edit/$id");

			# Si se produce un error en la BDD
		} catch (SQLException $e) {

			Session::error("No se pudo actualizar el anuncio $anuncio->nombre.");

			# Si estamos en modo debug, si que iremos a la página de error
			if (DEBUG)
				throw new Exception($e->getMessage());

			# Si no , volveremos de nuevo a la operación de edición.

			redirect("/anuncio/edit/$id");
		} catch (UploadException $e) {
			Session::warning("Cambios guardados, pero no se modificó la foto.");

			if (DEBUG)
				throw new Exception($e->getMessage());
			redirect("/anuncio/edit/$id");
		}

	}

    #---------------------------------------------------------------------#
    #----------------->        Borrar un anuncio        <-----------------#
    #---------------------------------------------------------------------#
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    #                                                                      
    
    public function delete(int $id = 0)
	{
		# Implementa el acceso al rol de administrador o de vendedor
		Auth::oneRole(['ROLE_ADMIN', 'ROLE_VENDOR']);
		
		$anuncio = Anuncio::findOrFail($id, "No existe el anuncio");

		view('anuncio/delete', [
			'anuncio' => $anuncio
		]);
	}

	public function destroy()
	{

		# Comprueba que llega el formulario

		if (!$this->request->has('borrar'))
			throw new FormException('No se recibio la confirmación');

		$id = intval($this->request->post('id'));		# Recupera el identificador
		$anuncio = Anuncio::findOrFail($id);				# Recupera el anuncio


		# Intenta borrar el anuncio	
		try {
			$anuncio->deleteObject($anuncio->id);

			if ($anuncio->portada)
				File::remove('../public' . USER_IMAGE_FOLDER . '/' . $anuncio->foto, true);

			Session::success("Se ha borrado el $anuncio->nombre correctamente.");
			redirect("/anuncio/list");

			# Si no lo borra produce un error en la operación con la BDD							
		} catch (SQLExcpetion $e) {
			Session::error("No se pudo borrar el anuncio $anuncio->nombre de la BDD");

			# Si estamos en DEBUG vamos a la vista "ERROR"
			if (DEBUG)
				throw new Exception($e->getMessage());

			# Si no retornamos al formulario de confirmación de borrado.					
			redirect("/anuncio/delete/$id");
		} catch (FileException $e) {
			Session::warning("Se eliminó el anuncio pero no la imagen");

			if (DEBUG)
				throw new Exception($e->getMessage());
			redirect("/anuncio/list");
		}
	}


    	#---------------------------------------------------------------------#
	#----------------->  MOSTRAR DETALLES DE UN ANUNCIO  <------------------#
	#---------------------------------------------------------------------#
	#                                                                      
	#                                                                      
	#                                                                      
	#                                                                      
	#                                                                      
	#                                                                      
	public function show(int $id = 0)
	{

		# Comprueba que llega el ID
		if (!$id)
			throw new NothigToFindException('No se indicó el anuncio a buscar.');

		#Recupera el anuncio
		$anuncio = Anuncio::findOrFail($id, "No se encontró el anuncio seleccionado");



		# Carga la vista y le pasa el anuncio recuperado
		view('anuncio/show', [
			'anuncio' => $anuncio

		]);
	}






}