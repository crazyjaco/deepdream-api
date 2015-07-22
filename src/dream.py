#!/usr/bin/python
import sys
from batcountry import BatCountry
from PIL import Image
import numpy as np

# dream.py <path_to_guide_image> <path_to_source_image> <path_to_save_image> <path_to_model>
# ./dream ./guide.jpg ./in.jpg ./out.jpg /opt/caffe/models/bvlc_googlenet
guide = sys.argv[1]
imgin = sys.argv[2]
imgout = sys.argv[3]

bc = BatCountry("/opt/caffe/models/bvlc_googlenet")
features = bc.prepare_guide(Image.open(guide))
image = bc.dream(np.float32(Image.open(imgin)),
	iter_n=20, objective_fn=BatCountry.guided_objective,
	objective_features=features,)
bc.cleanup()
result = Image.fromarray(np.uint8(image))
result.save(imgout)
