<fieldset>
                <legend>Informacion general</legend>

                <label for="titulo">Titulo:</label>
                <input 
                    type="text" 
                    name="titulo" 
                    id="titulo" 
                    placeholder="Titulo Propiedad" 
                    value="<?php echo s($propiedad->titulo); ?>"
                >

                <label for="precio">Precio:</label>
                <input 
                    type="number" 
                    name="precio" 
                    id="precio" 
                    placeholder="Precio Propiedad" 
                    value="<?php echo s($propiedad->precio) ?>"
                >

                <label for="imagen">Imagen:</label>
                <input 
                    type="file" 
                    name="imagen" 
                    id="imagen"
                    accept="image/jpeg, image/png" 
                >

                <label for="descripcion">Descripcion:</label>
                <textarea 
                    name="descripcion" 
                    id="descripcion"
                ><?php echo s($propiedad->descripcion); ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input 
                    type="number" 
                    name="habitaciones" 
                    id="habitaciones" 
                    placeholder="Ej. 3" 
                    min="1" 
                    max="9" 
                    value="<?php echo s($propiedad->habitaciones) ?>"
                >

                <label for="wc">Baños:</label>
                <input 
                    type="number" 
                    name="wc" 
                    id="wc" 
                    placeholder="Ej. 1" 
                    min="1"
                    max="9" 
                    value="<?php echo s($propiedad->wc)?>"
                >

                <label for="estacionamiento">Estacionamiento:</label>
                <input 
                    type="number" 
                    name="estacionamiento" 
                    id="estacionamiento" 
                    placeholder="Ej. 2" 
                    min="1" 
                    max="9" 
                    value="<?php echo s($propiedad->estacionamiento) ?>"
                >
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                
            </fieldset>